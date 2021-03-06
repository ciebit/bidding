<?php
namespace Ciebit\Bidding\Persons\Storages\Database;

use Ciebit\Bidding\Documents\Cnpj;
use Ciebit\Bidding\Documents\Cpf;
use Ciebit\Bidding\Persons\Collection;
use Ciebit\Bidding\Persons\Person;
use Ciebit\Bidding\Persons\Legal;
use Ciebit\Bidding\Persons\Natural;
use Ciebit\Bidding\Persons\Storages\Database\Database;
use Ciebit\Bidding\Persons\Storages\Storage;
use Ciebit\SqlHelper\Sql as SqlHelper;
use Exception;
use PDO;

use function array_map;
use function get_class;
use function strrchr;
use function substr;

class Sql implements Database
{
    /** @var string */
    private const FIELD_DOCUMENT = 'document';

    /** @var string */
    private const FIELD_ID = 'id';

    /** @var string */
    private const FIELD_NAME = 'name';

    /** @var string */
    private const FIELD_OFFICE = 'office';

    /** @var string */
    private const FIELD_TYPE = 'type';

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
        $this->table = 'cb_bidding_persons';
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

    private function build(array $data): Person
    {
        switch($data[self::FIELD_TYPE]) {
            case 'Natural': 
                return $this->buildNatural($data);
            case 'Legal': 
                return $this->buildLegal($data);
        }

        throw new Exception('storages.database.sql.build', '2');
    }

    private function buildLegal(array $data): Legal
    { 
        return new Legal(
            (string) $data[self::FIELD_NAME],
            new Cnpj($data[self::FIELD_DOCUMENT]),
            (string) $data[self::FIELD_ID]
        );
    }

    private function buildNatural(array $data): Natural
    { 
        return new Natural(
            (string) $data[self::FIELD_NAME],
            new Cpf($data[self::FIELD_DOCUMENT]),
            (string) $data[self::FIELD_OFFICE],
            (string) $data[self::FIELD_ID]
        );
    }

    private function getFields(): string
    {
        return implode(',', [
            self::FIELD_DOCUMENT,
            self::FIELD_ID,
            self::FIELD_NAME,
            self::FIELD_OFFICE,
            self::FIELD_TYPE
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
            throw new Exception('person.storages.database.sql.sintaxe_error', 3);
        }

        /** @var \PDOStatement $statement */
        $this->sqlHelper->bind($statement);

        if ($statement->execute() === false) {
            throw new Exception('storages.database.sql.get_error', 2);
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
    public function store(Person $person): string
    {
        $statement = $this->pdo->prepare(
            $sql = "INSERT INTO {$this->table} (
                {$this->getFields()}
            ) VALUES (
                :document, :id, :name, :office, :type
            )"
        );

        $type = substr(strrchr(get_class($person), '\\'), 1);
        $office = null;
        if ($person instanceof Natural) {
            $office = $person->getOffice();
        }

        $statement->bindValue(':document', $person->getDocument()->getValue(), PDO::PARAM_STR);
        $statement->bindValue(':id', $person->getId(), PDO::PARAM_INT);
        $statement->bindValue(':name', $person->getName(), PDO::PARAM_STR);
        $statement->bindValue(':type', $type, PDO::PARAM_STR);
        $statement->bindValue(':office', $office, PDO::PARAM_STR);

        if (!$statement->execute()) {
            throw new Exception('storages.database.sql.store_error', 3);
        }

        return $this->pdo->lastInsertId();
    }

    private function updateTotalItemsWithoutFilters(): self
    {
        $this->totalItemsOfLastFindWithoutLimitations = $this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return $this;
    }
}
