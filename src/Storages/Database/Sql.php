<?php

namespace Ciebit\Bidding\Storages\Database;

use Ciebit\Bidding\Bidding;
use Ciebit\Bidding\Collection;
use Ciebit\Bidding\Modality;
use Ciebit\Bidding\Place;
use Ciebit\Bidding\Status;
use Ciebit\Bidding\Storages\Database\Database;
use Ciebit\Bidding\Storages\Storage;
use Ciebit\Bidding\Type;
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
    private const COLUMN_COMMITTEE_ID = 'committee_id';

    /** @var string */
    private const COLUMN_ESTIMATE_BUDGET_AMOUNT = 'estimate_budget_amount';

    /** @var string */
    private const COLUMN_ID = 'id';

    /** @var string */
    private const COLUMN_FILES_ID = 'files_id';

    /** @var string */
    private const COLUMN_MODALITY = 'modality';

    /** @var string */
    private const COLUMN_NOTICE_PUBLICATION_DATE = 'notice_publication_date';

    /** @var string */
    private const COLUMN_NUMBER = 'number';

    /** @var string */
    private const COLUMN_OBJECT_DESCRIPTION = 'object_description';

    /** @var string */
    private const COLUMN_OPENING_DATE_TIME = 'opening_date_time';

    /** @var string */
    private const COLUMN_OPENING_PLACE_ADDRESS = 'opening_place_address';

    /** @var string */
    private const COLUMN_OPENING_PLACE_CITY = 'opening_place_city';

    /** @var string */
    private const COLUMN_OPENING_PLACE_COMPLEMENT = 'opening_place_complement';

    /** @var string */
    private const COLUMN_OPENING_PLACE_NAME = 'opening_place_name';

    /** @var string */
    private const COLUMN_OPENING_PLACE_NEIGHBORHOOD = 'opening_place_neighborhood';

    /** @var string */
    private const COLUMN_OPENING_PLACE_NUMBER = 'opening_place_number';

    /** @var string */
    private const COLUMN_OPENING_PLACE_STATE = 'opening_place_state';

    /** @var string */
    private const COLUMN_OPENING_PLACE_ZIPCODE = 'opening_place_zipcode';

    /** @var string */
    private const COLUMN_ORGANS_ID = 'organs_id';

    /** @var string */
    private const COLUMN_PERSON_ORDERED_ID = 'person_ordered_id';

    /** @var string */
    private const COLUMN_RESPONSIBLE_APPROVAL_ID = 'responsible_approval_id';

    /** @var string */
    private const COLUMN_RESPONSIBLE_AWARD_ID = 'responsible_award_id';

    /** @var string */
    private const COLUMN_RESPONSIBLE_INFORMATION_ID = 'responsible_information_id';

    /** @var string */
    private const COLUMN_RESPONSIBLE_LEGAL_ADVICE_ID = 'responsible_legal_advice_id';

    /** @var string */
    private const COLUMN_STATUS = 'status';

    /** @var string */
    private const COLUMN_TYPE = 'type';

    /** @var string */
    private const COLUMN_UPPER_LIMITE_VALUE = 'upper_limite_value';

    /** @var string */
    private const COLUMN_YEAR_OF_EXERCISE = 'year_of_exercise';

    /** @var string */
    private const FILES_COLUMN_BIDDING_ID = 'bidding_id';

    /** @var string */
    private const FILES_COLUMN_FILE_ID = 'file_id';

    /** @var string */
    private const ORGANS_COLUMN_BIDDING_ID = 'bidding_id';

    /** @var string */
    private const ORGANS_COLUMN_ORGAN_ID = 'organ_id';

    /** @var PDO */
    private $pdo;

    /** @var SqlHelper */
    private $sqlHelper;

    /** @var string */
    private $table;

    /** @var string */
    private $tableFiles;

    /** @var string */
    private $tableOrgans;

    /** @var int */
    private $totalItemsOfLastFindWithoutLimitations;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->sqlHelper = new SqlHelper;
        $this->table = 'cb_bidding';
        $this->tableFiles = 'cb_bidding_files';
        $this->tableOrgans = 'cb_bidding_organs_association';
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
        $this->addFilter(self::COLUMN_ID, PDO::PARAM_INT, $operator, ...$ids);
        return $this;
    }

    public function addOrderBy(string $field, string $direction): Storage
    {
        $this->sqlHelper->addOrderBy($field, $direction);
        return $this;
    }

    private function build(array $data): Bidding
    {
        $place = new Place(
            $data[self::COLUMN_OPENING_PLACE_NAME],
            $data[self::COLUMN_OPENING_PLACE_ADDRESS],
            $data[self::COLUMN_OPENING_PLACE_NUMBER],
            $data[self::COLUMN_OPENING_PLACE_NEIGHBORHOOD],
            $data[self::COLUMN_OPENING_PLACE_COMPLEMENT],
            $data[self::COLUMN_OPENING_PLACE_CITY],
            $data[self::COLUMN_OPENING_PLACE_STATE],
            (int) $data[self::COLUMN_OPENING_PLACE_ZIPCODE]
        );

        $bidding = new Bidding(
            new Year((int) $data[self::COLUMN_YEAR_OF_EXERCISE]),
            new Modality((int) $data[self::COLUMN_MODALITY]),
            new Type((int) $data[self::COLUMN_TYPE]),
            $data[self::COLUMN_NUMBER],
            $data[self::COLUMN_COMMITTEE_ID],
            (float) $data[self::COLUMN_ESTIMATE_BUDGET_AMOUNT],
            $data[self::COLUMN_UPPER_LIMITE_VALUE],
            $data[self::COLUMN_OBJECT_DESCRIPTION],
            explode(',', $data[self::COLUMN_ORGANS_ID]),
            new DateTime($data[self::COLUMN_OPENING_DATE_TIME]),
            $place,
            new DateTime($data[self::COLUMN_NOTICE_PUBLICATION_DATE]),
            $data[self::COLUMN_PERSON_ORDERED_ID],
            $data[self::COLUMN_RESPONSIBLE_INFORMATION_ID],
            $data[self::COLUMN_RESPONSIBLE_LEGAL_ADVICE_ID],
            $data[self::COLUMN_RESPONSIBLE_AWARD_ID],
            $data[self::COLUMN_RESPONSIBLE_APPROVAL_ID],
            new Status((int) $data[self::COLUMN_STATUS]),
            $data[self::COLUMN_ID]
        );

        if (isset($data[self::COLUMN_FILES_ID])) {
            $bidding->addFileId(...explode(',', $data[self::COLUMN_FILES_ID]));
        }


        return $bidding;
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
                    ) AS `%s`,
                    (
                        SELECT GROUP_CONCAT(`%s`)
                        FROM `{$this->tableOrgans}` 
                        WHERE `{$this->tableOrgans}`.`%s` = `{$this->table}`.`%s`
                    ) AS `%s`
                FROM `{$this->table}`
                {$this->sqlHelper->generateSqlJoin()}
                WHERE {$this->sqlHelper->generateSqlFilters()}
                {$this->sqlHelper->generateSqlOrder()}
                {$this->sqlHelper->generateSqlLimit()}",
                self::FILES_COLUMN_FILE_ID,
                self::FILES_COLUMN_BIDDING_ID,
                self::COLUMN_ID,
                self::COLUMN_FILES_ID,
                self::ORGANS_COLUMN_ORGAN_ID,
                self::ORGANS_COLUMN_BIDDING_ID,
                self::COLUMN_ID,
                self::COLUMN_ORGANS_ID
            )
        );

        $this->sqlHelper->bind($statement);

        if ($statement->execute() === false) {
            throw new Exception('storages.database.sql.find_error', 2);
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

    public function setLimit(int $limit): Storage
    {
        $this->sqlHelper->setLimit($limit);
        return $this;
    }

    public function setOffset(int $offset): Storage
    {
        $this->sqlHelper->setOffset($offset);
        return $this;
    }

    /** @throws Exception */
    public function store(Bidding $bidding): string
    {
        try {
            $this->pdo->beginTransaction();
            $id = $this->storeBidding($bidding);
            $this->storeFilesId($id, $bidding->getFilesId());
            $this->storeOrgansId($id, $bidding->getOrgansId());
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        return $id;
    }

    /** @throws Exception */
    public function storeBidding(Bidding $bidding): string
    {
        $statement = $this->pdo->prepare(
            sprintf(
                "INSERT INTO {$this->table} (
                    %s, %s, %s, %s, %s, 
                    %s, %s, %s, %s, %s,
                    %s, %s, %s, %s, %s, 
                    %s, %s, %s, %s, %s,
                    %s, %s, %s, %s
                ) VALUES (
                    :committeeId,
                    :estimateBudgetAmount,
                    :modality,
                    :noticePublicationDate,
                    :number,
                    :objectDescription,
                    :openingDateTime,
                    :openingPlaceAddress,
                    :openingPlaceCity,
                    :openingPlaceComplement,
                    :openingPlaceName,
                    :openingPlaceNeighborhood,
                    :openingPlaceNumber,
                    :openingPlaceState,
                    :openingPlaceZipcode,
                    :personOrderedId,
                    :responsibleApprovalId,
                    :responsibleAwardId,
                    :responsibleInformationId,
                    :responsibleLegalAdviceId,
                    :status,
                    :type,
                    :upperLimiteValue,
                    :yearOfExercise
                )",
                self::COLUMN_COMMITTEE_ID,
                self::COLUMN_ESTIMATE_BUDGET_AMOUNT,
                self::COLUMN_MODALITY,
                self::COLUMN_NOTICE_PUBLICATION_DATE,
                self::COLUMN_NUMBER,
                self::COLUMN_OBJECT_DESCRIPTION,
                self::COLUMN_OPENING_DATE_TIME,
                self::COLUMN_OPENING_PLACE_ADDRESS,
                self::COLUMN_OPENING_PLACE_CITY,
                self::COLUMN_OPENING_PLACE_COMPLEMENT,
                self::COLUMN_OPENING_PLACE_NAME,
                self::COLUMN_OPENING_PLACE_NEIGHBORHOOD,
                self::COLUMN_OPENING_PLACE_NUMBER,
                self::COLUMN_OPENING_PLACE_STATE,
                self::COLUMN_OPENING_PLACE_ZIPCODE,
                self::COLUMN_PERSON_ORDERED_ID,
                self::COLUMN_RESPONSIBLE_APPROVAL_ID,
                self::COLUMN_RESPONSIBLE_AWARD_ID,
                self::COLUMN_RESPONSIBLE_INFORMATION_ID,
                self::COLUMN_RESPONSIBLE_LEGAL_ADVICE_ID,
                self::COLUMN_STATUS,
                self::COLUMN_TYPE,
                self::COLUMN_UPPER_LIMITE_VALUE,
                self::COLUMN_YEAR_OF_EXERCISE
            )
        );

        $statement->bindValue(':committeeId', $bidding->getCommitteeId(), PDO::PARAM_INT);
        $statement->bindValue(':estimateBudgetAmount', $bidding->getEstimatedBudgetAmount(), PDO::PARAM_STR);
        $statement->bindValue(':modality', $bidding->getModality()->getValue(), PDO::PARAM_INT);
        $statement->bindValue(':noticePublicationDate', $bidding->getNoticePublicationDate()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $statement->bindValue(':number', $bidding->getNumber(), PDO::PARAM_STR);
        $statement->bindValue(':objectDescription', $bidding->getObjectDescription(), PDO::PARAM_STR);
        $statement->bindValue(':openingDateTime', $bidding->getOpeningDateTime()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceAddress', $bidding->getOpeningPlace()->getAddress(), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceCity', $bidding->getOpeningPlace()->getCity(), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceComplement', $bidding->getOpeningPlace()->getComplement(), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceName', $bidding->getOpeningPlace()->getName(), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceNeighborhood', $bidding->getOpeningPlace()->getNeighborhood(), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceNumber', $bidding->getOpeningPlace()->getNumber(), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceState', $bidding->getOpeningPlace()->getState(), PDO::PARAM_STR);
        $statement->bindValue(':openingPlaceZipcode', $bidding->getOpeningPlace()->getZipcode(), PDO::PARAM_INT);
        $statement->bindValue(':personOrderedId', $bidding->getPersonOrderedId(), PDO::PARAM_INT);
        $statement->bindValue(':responsibleApprovalId', $bidding->getResponsibleApprovalId(), PDO::PARAM_INT);
        $statement->bindValue(':responsibleAwardId', $bidding->getResponsibleAwardId(), PDO::PARAM_INT);
        $statement->bindValue(':responsibleInformationId', $bidding->getResponsibleInformationId(), PDO::PARAM_INT);
        $statement->bindValue(':responsibleLegalAdviceId', $bidding->getResponsibleLegalAdviceId(), PDO::PARAM_INT);
        $statement->bindValue(':status', $bidding->getStatus()->getValue(), PDO::PARAM_INT);
        $statement->bindValue(':type', $bidding->getType()->getValue(), PDO::PARAM_INT);
        $statement->bindValue(':upperLimiteValue', $bidding->getUpperLimitValue(), PDO::PARAM_STR);
        $statement->bindValue(':yearOfExercise', $bidding->getYearOfExercise()->getInt(), PDO::PARAM_INT);

        if (! $statement->execute()) {
            throw new Exception('storages.database.sql.store_error', 3);
        }

        return $this->pdo->lastInsertId();
    }

    /** @throws Exception */
    private function storeFilesId(string $biddingId, array $filesId): self
    {
        $total = count($filesId);
        if ($total <= 0) {
            return $this;
        }

        $values = [];
        for ($i = 0; $i < $total; $i++) {
            $values[] = "(:bidding_id, :file_id_{$i})";
        }

        $fieldBiddingId = self::FILES_COLUMN_BIDDING_ID;
        $fieldFileId = self::FILES_COLUMN_FILE_ID;

        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->tableFiles} (
                `{$fieldBiddingId}`, `{$fieldFileId}`
            ) VALUES " . implode(',', $values)
        );

        $statement->bindValue(':bidding_id', $biddingId, PDO::PARAM_INT);

        for ($i = 0; $i < $total; $i++) {
            $statement->bindValue(
                ":file_id_{$i}",
                $filesId[$i],
                PDO::PARAM_INT
            );
        }

        if (!$statement->execute()) {
            throw new Exception('storages.store_association_files', 3);
        }

        return $this;
    }

    /** @throws Exception */
    private function storeOrgansId(string $biddingId, array $organsId): self
    {
        $total = count($organsId);
        if ($total <= 0) {
            return $this;
        }

        $values = [];
        for ($i = 0; $i < $total; $i++) {
            $values[] = "(:bidding_id, :organ_id_{$i})";
        }

        $fieldBiddingId = self::ORGANS_COLUMN_BIDDING_ID;
        $fieldOrganId = self::ORGANS_COLUMN_ORGAN_ID;

        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->tableOrgans} (
                `{$fieldBiddingId}`, `{$fieldOrganId}`
            ) VALUES " . implode(',', $values)
        );

        $statement->bindValue(':bidding_id', $biddingId, PDO::PARAM_INT);

        for ($i = 0; $i < $total; $i++) {
            $statement->bindValue(
                ":organ_id_{$i}",
                $organsId[$i],
                PDO::PARAM_INT
            );
        }

        if (!$statement->execute()) {
            throw new Exception('storages.store_association_organs', 3);
        }

        return $this;
    }

    private function updateTotalItemsWithoutFilters(): self
    {
        $this->totalItemsOfLastFindWithoutLimitations = $this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return $this;
    }
}
