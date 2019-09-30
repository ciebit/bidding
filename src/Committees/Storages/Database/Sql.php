<?php
namespace Ciebit\Bidding\Committees\Storages\Database;

use Ciebit\Bidding\Committees\Collection;
use Ciebit\Bidding\Committees\Committee;
use Ciebit\Bidding\Committees\Storages\Database\Database;
use Ciebit\Bidding\Committees\Storages\Storage;
use Ciebit\SqlHelper\Sql as SqlHelper;
use DateTime;
use Exception;
use PDO;

use function array_map;
use function sprintf;

class Sql implements Database
{
    /** @var string */
    private const FIELD_DATE_CREATION = 'date_creation';

    /** @var string */
    private const FIELD_EXTERNAL_ID = 'external_id';

    /** @var string */
    private const FIELD_MANAGER_ID = 'manager_id';
    
    /** @var string */
    private const FIELD_MEMBERS_ID = 'members_id';
    
    /** @var string */
    private const FIELD_NAME = 'name';
    
    /** @var string */
    private const FIELD_ID = 'id';

    /** @var string */
    private const MEMBERS_FIELD_COMMITTE_ID = 'committee_id';

    /** @var string */
    private const MEMBERS_FIELD_PERSON_ID = 'person_id';

    /** @var PDO */
    private $pdo;

    /** @var SqlHelper */
    private $sqlHelper;

    /** @var string */
    private $table;

    /** @var string */
    private $tableMembers;

    /** @var int */
    private $totalItemsOfLastFindWithoutLimitations;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->sqlHelper = new SqlHelper;
        $this->table = 'cb_bidding_committees';
        $this->tableMembers = 'cb_bidding_committees_members';
        $this->totalItemsOfLastFindWithoutLimitations = 0;
    }

    private function addFilter(string $fieldName, int $type, string $operator, ...$value): self
    {
        $field = "`{$this->table}`.`{$fieldName}`";
        $this->sqlHelper->addFilterBy($field, $type, $operator, ...$value);
        return $this;
    }

    public function addFilterById(string $operator, string ...$ids): Storage
    {
        $ids = array_map('intval', $ids);
        $this->addFilter(self::FIELD_ID, PDO::PARAM_INT, $operator, ...$ids);
        return $this;
    }

    private function build(array $data): Committee
    {
        return new Committee(
            $data[self::FIELD_NAME],
            new DateTime($data[self::FIELD_DATE_CREATION]),
            $data[self::FIELD_EXTERNAL_ID],
            $data[self::FIELD_MANAGER_ID],
            explode(',', $data[self::FIELD_MEMBERS_ID]),
            $data[self::FIELD_ID]
        );
    }

    /** @throws Exception */
    public function find(): Collection
    {
        $statement = $this->pdo->prepare(
            sprintf(
                "SELECT SQL_CALC_FOUND_ROWS
                    `{$this->table}`.* ,
                    (
                        SELECT GROUP_CONCAT(`%s`)
                        FROM `{$this->tableMembers}` 
                        WHERE `{$this->tableMembers}`.`%s` = `{$this->table}`.`%s`
                    ) AS `%s`
                FROM `{$this->table}`
                {$this->sqlHelper->generateSqlJoin()}
                WHERE {$this->sqlHelper->generateSqlFilters()}
                {$this->sqlHelper->generateSqlOrder()}
                {$this->sqlHelper->generateSqlLimit()}",
                self::MEMBERS_FIELD_PERSON_ID,
                self::MEMBERS_FIELD_COMMITTE_ID,
                self::FIELD_ID,
                self::FIELD_MEMBERS_ID
            )
        );

        $this->sqlHelper->bind($statement);

        if ($statement->execute() === false) {
            throw new Exception('committees.storages.database.sql.find_error', 2);
        }

        $this->updateTotalItemsWithoutFilters();

        $collection = new Collection;

        while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
            $collection->add(
                $this->build($data)
            );
        }

        return $collection;
    }


    /** @throws Exception */
    public function store(Committee $committee): string
    {
        try {
            $this->pdo->beginTransaction();
            $id = $this->storecommittee($committee);
            $this->storeMembersId($id, $committee->getMembersId());
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        return $id;
    }

    /** @throws Exception */
    public function storeCommittee(Committee $committee): string
    {
        $statement = $this->pdo->prepare(
            sprintf(
                "INSERT INTO {$this->table} (
                    %s, %s, %s, %s
                ) VALUES (
                    :name,
                    :externalId,
                    :dateCreation,
                    :managerId
                )",
                self::FIELD_NAME,
                self::FIELD_EXTERNAL_ID,
                self::FIELD_DATE_CREATION,
                self::FIELD_MANAGER_ID
            )
        );


        $statement->bindValue(':dateCreation', $committee->getDateCreation()->format('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(':externalId', $committee->getExternalId(), PDO::PARAM_STR);
        $statement->bindValue(':managerId', $committee->getManagerId(), PDO::PARAM_INT);
        $statement->bindValue(':name', $committee->getName(), PDO::PARAM_STR);

        if (! $statement->execute()) {
            throw new Exception('committees.storages.database.sql.store_error', 3);
        }

        return $this->pdo->lastInsertId();
    }

    /** @throws Exception */
    public function storeMembersId(string $committeeId, array $membersId): self
    {
        $total = count($membersId);
        if ($total <= 0) {
            return $this;
        }

        $values = [];
        for ($i = 0; $i < $total; $i++) {
            $values[] = "(:committee_id, :person_id_{$i})";
        }

        $fieldCommitteeId = self::MEMBERS_FIELD_COMMITTE_ID;
        $fieldPesonId = self::MEMBERS_FIELD_PERSON_ID;

        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->tableMembers} (
                `{$fieldCommitteeId}`, `{$fieldPesonId}`
            ) VALUES " . implode(',', $values)
        );

        $statement->bindValue(':committee_id', $committeeId, PDO::PARAM_INT);

        for ($i = 0; $i < $total; $i++) {
            $statement->bindValue(
                ":person_id_{$i}",
                $membersId[$i],
                PDO::PARAM_INT
            );
        }

        if (! $statement->execute()) {
            throw new Exception('committees.storages.store_association_members', 3);
        }

        return $this;
    }

    private function updateTotalItemsWithoutFilters(): self
    {
        $this->totalItemsOfLastFindWithoutLimitations = $this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return $this;
    }
}
