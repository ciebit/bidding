<?php
namespace Ciebit\Bidding\Organs\Storages\Database;

use Ciebit\Bidding\Organs\Collection;
use Ciebit\Bidding\Organs\Organ;
use Ciebit\Bidding\Organs\Storages\Database\Database;
use Ciebit\Bidding\Organs\Storages\Storage;
use Ciebit\SqlHelper\Sql as SqlHelper;
use Exception;
use PDO;

use function array_map;

class Sql implements Database
{
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
        $this->table = 'cb_bidding_organs';
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

    private function build(array $data): Organ
    {
        return new Organ(
            $data[self::FIELD_NAME],
            $data[self::FIELD_ID]
        );
    }

    private function getFields(): string
    {
        return implode(',', [
            self::FIELD_ID,
            self::FIELD_NAME
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
            throw new Exception('organs.storages.database.sql.get_error', 2);
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
    public function store(Organ $organ): string
    {
        $name = self::FIELD_NAME;

        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->table} (
                `$name`
            ) VALUES (
                :name
            )"
        );

        $statement->bindValue(':name', $organ->getName(), PDO::PARAM_STR);

        if (!$statement->execute()) {
            throw new Exception('organs.storages.database.sql.store_error', 3);
        }

        return $this->pdo->lastInsertId();
    }

    private function updateTotalItemsWithoutFilters(): self
    {
        $this->totalItemsOfLastFindWithoutLimitations = $this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return $this;
    }
}
