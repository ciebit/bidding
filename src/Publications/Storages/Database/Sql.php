<?php
namespace Ciebit\Bidding\Publications\Storages\Database;

use Ciebit\Bidding\Publications\Collection;
use Ciebit\Bidding\Publications\Publication;
use Ciebit\Bidding\Publications\Storages\Database\Database;
use Ciebit\Bidding\Publications\Storages\Storage;
use Ciebit\SqlHelper\Sql as SqlHelper;
use DateTime;
use Exception;
use PDO;

use function array_map;
use function get_class;
use function strrchr;
use function substr;

class Sql implements Database
{
    /** @var string */
    private const FIELD_BIDDING_ID = 'bidding_id';

    /** @var string */
    private const FIELD_DATE = 'date';

    /** @var string */
    private const FIELD_DESCRIPTION = 'description';

    /** @var string */
    private const FIELD_FILE_ID = 'file_id';

    /** @var string */
    private const FIELD_ID = 'id';

    /** @var string */
    private const FIELD_NAME = 'name';

    /** @var PDO */
    private $pdo;

    /** @var SqlHelper */
    private $sqlHelper;

    /** @var int */
    private $totalItemsOfLastFindWithoutLimitations;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->sqlHelper = new SqlHelper;
        $this->table = 'cb_bidding_publications';
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

    private function build(array $data): Publication
    {
        return new Publication(
            $data[self::FIELD_NAME],
            $data[self::FIELD_DESCRIPTION],
            new DateTime($data[self::FIELD_DATE]),
            $data[self::FIELD_BIDDING_ID],
            $data[self::FIELD_FILE_ID],
            $data[self::FIELD_ID]
        );
    }

    private function getFields(): string
    {
        return implode(',', [
            self::FIELD_BIDDING_ID,
            self::FIELD_DATE,
            self::FIELD_DESCRIPTION,
            self::FIELD_FILE_ID,
            self::FIELD_ID,
            self::FIELD_NAME,
        ]);
    }

    /** @throws Exception */
    public function find(): Collection
    {
        $statement = $this->pdo->prepare(
            "SELECT SQL_CALC_FOUND_ROWS
            {$this->getFields()}
            FROM `{$this->table}`
            {$this->sqlHelper->generateSqlJoin()}
            WHERE {$this->sqlHelper->generateSqlFilters()}
            {$this->sqlHelper->generateSqlOrder()}
            {$this->sqlHelper->generateSqlLimit()}"
        );

        $this->sqlHelper->bind($statement);

        if ($statement->execute() === false) {
            throw new Exception('publications.storages.database.sql.get_error', 2);
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
    public function store(Publication $publication): string
    {
        $fields = str_replace(','.self::FIELD_ID.',', ',', $this->getFields());

        $statement = $this->pdo->prepare(
            $sql = "INSERT INTO {$this->table} (
                {$fields}
            ) VALUES (
                :biddingId,
                :date,
                :description,
                :fileId,
                :name
            )"
        );

        $statement->bindValue(':biddingId', $publication->getBiddingId(), PDO::PARAM_INT);
        $statement->bindValue(':date', $publication->getDate()->format('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(':description', $publication->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(':fileId', $publication->getFileId(), PDO::PARAM_INT);
        $statement->bindValue(':name', $publication->getName(), PDO::PARAM_STR);

        if (!$statement->execute()) {
            echo $sql;
            var_dump($statement->errorInfo());
            throw new Exception('publications.storages.database.sql.store_error', 3);
        }

        return $this->pdo->lastInsertId();
    }

    private function updateTotalItemsWithoutFilters(): self
    {
        $this->totalItemsOfLastFindWithoutLimitations = $this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return $this;
    }
}
