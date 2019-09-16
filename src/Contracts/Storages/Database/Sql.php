<?php

namespace Ciebit\Bidding\Contracts\Storages\Database;

use Ciebit\Bidding\Contracts\Collection;
use Ciebit\Bidding\Contracts\Contract;
use Ciebit\Bidding\Contracts\Storages\Database\Database;
use Ciebit\Bidding\Contracts\Storages\Storage;
use Ciebit\Bidding\Year;
use Ciebit\SqlHelper\Sql as SqlHelper;
use DateTime;
use Exception;
use PDO;

use function array_map;
use function sprintf;

class Sql implements Database
{
    /** @var string */
    private const FIELD_BIDDING_ID = 'bidding_id';

    /** @var string */
    private const FIELD_DATE = 'date';

    /** @var string */
    private const FIELD_FILES_ID = 'files_id';

    /** @var string */
    private const FIELD_FINAL_DATE = 'final_date';

    /** @var string */
    private const FIELD_GLOBAL_PRICE = 'global_price';

    /** @var string */
    private const FIELD_ID = 'id';

    /** @var string */
    private const FIELD_NUMBER = 'number';

    /** @var string */
    private const FIELD_OBJECT_DESCRIPTION = 'object_description';

    /** @var string */
    private const FIELD_ORGAN_ID = 'organ_id';

    /** @var string */
    private const FIELD_PERSON_ID = 'person_id';

    /** @var string */
    private const FIELD_START_DATE = 'start_date';

    /** @var string */
    private const FIELD_YEAR_OF_EXERCISE = 'year_of_exercise';
    
    /** @var string */
    private const FILES_FIELD_CONTRACT_ID = 'contract_id';

    /** @var string */
    private const FILES_FIELD_FILE_ID = 'file_id';

    /** @var PDO */
    private $pdo;

    /** @var SqlHelper */
    private $sqlHelper;

    /** @var string */
    private $table;

    /** @var string */
    private $tableFiles;

    /** @var int */
    private $totalItemsOfLastFindWithoutLimitations;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->sqlHelper = new SqlHelper;
        $this->table = 'cb_bidding_contracts';
        $this->tableFiles = 'cb_bidding_contracts_files';
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

    private function build(array $data): Contract
    {
        $contract = new Contract(
            $data[self::FIELD_BIDDING_ID],
            new Year((int) $data[self::FIELD_YEAR_OF_EXERCISE]),
            $data[self::FIELD_NUMBER],
            new DateTime($data[self::FIELD_DATE]),
            new DateTime($data[self::FIELD_START_DATE]),
            new DateTime($data[self::FIELD_FINAL_DATE]),
            (float) $data[self::FIELD_GLOBAL_PRICE],
            $data[self::FIELD_OBJECT_DESCRIPTION],
            $data[self::FIELD_ORGAN_ID],
            $data[self::FIELD_PERSON_ID],
            $data[self::FIELD_ID]
        );
        $contract->addFileId(...explode(',', $data[self::FIELD_FILES_ID]));

        return $contract;
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
                        FROM `{$this->tableFiles}` 
                        WHERE `{$this->tableFiles}`.`%s` = `{$this->table}`.`%s`
                    ) AS `%s`
                FROM `{$this->table}`
                {$this->sqlHelper->generateSqlJoin()}
                WHERE {$this->sqlHelper->generateSqlFilters()}
                {$this->sqlHelper->generateSqlOrder()}
                {$this->sqlHelper->generateSqlLimit()}",
                self::FILES_FIELD_FILE_ID,
                self::FILES_FIELD_CONTRACT_ID,
                self::FIELD_ID,
                self::FIELD_FILES_ID
            )
        );

        $this->sqlHelper->bind($statement);

        if ($statement->execute() === false) {
            throw new Exception('contracts.storages.database.sql.find_error', 2);
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

    public function getTotalItemsOfLastFindWithoutLimitations(): int
    {
        return $this->totalItemsOfLastFindWithoutLimitations;
    }


    /** @throws Exception */
    public function store(Contract $contract): string
    {
        try {
            $this->pdo->beginTransaction();
            $id = $this->storeContract($contract);
            $this->storeFilesId($id, $contract->getFilesId());
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        return $id;
    }

    /** @throws Exception */
    public function storeContract(Contract $contract): string
    {
        $statement = $this->pdo->prepare(
            sprintf(
                "INSERT INTO {$this->table} (
                    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s
                ) VALUES (
                    :number,
                    :yearOfExercise,
                    :biddingId,
                    :organId,
                    :personId,
                    :date,
                    :startDate,
                    :finalDate,
                    :globalPrice,
                    :objectDescription
                )",
                self::FIELD_NUMBER,
                self::FIELD_YEAR_OF_EXERCISE,
                self::FIELD_BIDDING_ID,
                self::FIELD_ORGAN_ID,
                self::FIELD_PERSON_ID,
                self::FIELD_DATE,
                self::FIELD_START_DATE,
                self::FIELD_FINAL_DATE,
                self::FIELD_GLOBAL_PRICE,
                self::FIELD_OBJECT_DESCRIPTION
            )
        );


        $statement->bindValue(':number', $contract->getNumber(), PDO::PARAM_STR);
        $statement->bindValue(':yearOfExercise', $contract->getYearOfExercise()->getInt(), PDO::PARAM_INT);
        $statement->bindValue(':biddingId', $contract->getBiddingId(), PDO::PARAM_INT);
        $statement->bindValue(':organId', $contract->getOrganId(), PDO::PARAM_INT);
        $statement->bindValue(':personId', $contract->getPersonId(), PDO::PARAM_INT);
        $statement->bindValue(':date', $contract->getDate()->format('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(':startDate', $contract->getStartDate()->format('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(':finalDate', $contract->getFinalDate()->format('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(':globalPrice', $contract->getGlobalPrice(), PDO::PARAM_INT);
        $statement->bindValue(':objectDescription', $contract->getObjectDescription(), PDO::PARAM_STR);

        if (! $statement->execute()) {
            throw new Exception('contracts.storages.database.sql.store_error', 3);
        }

        return $this->pdo->lastInsertId();
    }

    /** @throws Exception */
    private function storeFilesId(string $contractId, array $filesId): self
    {
        $total = count($filesId);
        if ($total <= 0) {
            return $this;
        }

        $values = [];
        for ($i = 0; $i < $total; $i++) {
            $values[] = "(:contract_id, :file_id_{$i})";
        }

        $fieldContractId = self::FILES_FIELD_CONTRACT_ID;
        $fieldFileId = self::FILES_FIELD_FILE_ID;

        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->tableFiles} (
                `{$fieldContractId}`, `{$fieldFileId}`
            ) VALUES " . implode(',', $values)
        );

        $statement->bindValue(':contract_id', $contractId, PDO::PARAM_INT);

        for ($i = 0; $i < $total; $i++) {
            $statement->bindValue(
                ":file_id_{$i}",
                $filesId[$i],
                PDO::PARAM_INT
            );
        }

        if (!$statement->execute()) {
            throw new Exception('contracts.storages.store_association_files', 3);
        }

        return $this;
    }

    private function updateTotalItemsWithoutFilters(): self
    {
        $this->totalItemsOfLastFindWithoutLimitations = $this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return $this;
    }
}
