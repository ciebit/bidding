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

class Sql implements Database
{
    /** @var string */
    private const COLUMN_BIDDING_ID = Storage::FIELD_BIDDING_ID;

    /** @var string */
    private const COLUMN_DATE = Storage::FIELD_DATE;

    /** @var string */
    private const COLUMN_DESCRIPTION = Storage::FIELD_DESCRIPTION;

    /** @var string */
    private const COLUMN_FILE_ID = Storage::FIELD_FILE_ID;

    /** @var string */
    private const COLUMN_ID = Storage::FIELD_ID;

    /** @var string */
    private const COLUMN_NAME = Storage::FIELD_NAME;

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

    public function addFilterByBiddingId(string $operator, string ...$ids): Storage
    {
        $ids = array_map('intval', $ids);
        $this->addFilter(self::COLUMN_BIDDING_ID, PDO::PARAM_INT, $operator, ...$ids);
        return $this;
    }

    public function addFilterById(string $operator, string ...$ids): Storage
    {
        $ids = array_map('intval', $ids);
        $this->addFilter(self::COLUMN_ID, PDO::PARAM_INT, $operator, ...$ids);
        return $this;
    }

    private function build(array $data): Publication
    {
        return new Publication(
            (string) $data[self::COLUMN_NAME],
            (string) $data[self::COLUMN_DESCRIPTION],
            new DateTime($data[self::COLUMN_DATE]),
            (string) $data[self::COLUMN_BIDDING_ID],
            (string) $data[self::COLUMN_FILE_ID],
            (string) $data[self::COLUMN_ID]
        );
    }

    private function getFields(): string
    {
        return implode(',', [
            self::COLUMN_BIDDING_ID,
            self::COLUMN_DATE,
            self::COLUMN_DESCRIPTION,
            self::COLUMN_FILE_ID,
            self::COLUMN_ID,
            self::COLUMN_NAME,
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

        if ($statement === false) {
            throw new Exception('bidding.publications.storages.database.sql.sintaxe_error', 3);
        }

        /** @var \PDOStatement $statement */
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
        $fields = str_replace(','.self::COLUMN_ID.',', ',', $this->getFields());

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
