<?php
namespace Ciebit\Bidding\Storages;

use Ciebit\Bidding\Collection;
use Ciebit\Bidding\Bidding;
use Ciebit\Bidding\Status;

interface Storage
{
    /** @var string */
    public const FIELD_COMMITTEE_ID = 'committee_id';

    /** @var string */
    public const FIELD_ESTIMATE_BUDGET_AMOUNT = 'estimate_budget_amount';

    /** @var string */
    public const FIELD_ID = 'id';

    /** @var string */
    public const FIELD_FILES_ID = 'files_id';

    /** @var string */
    public const FIELD_MODALITY = 'modality';

    /** @var string */
    public const FIELD_NOTICE_PUBLICATION_DATE = 'notice_publication_date';

    /** @var string */
    public const FIELD_NUMBER = 'number';

    /** @var string */
    public const FIELD_OBJECT_DESCRIPTION = 'object_description';

    /** @var string */
    public const FIELD_OPENING_DATE_TIME = 'opening_date_time';

    /** @var string */
    public const FIELD_OPENING_PLACE_ADDRESS = 'opening_place_address';

    /** @var string */
    public const FIELD_OPENING_PLACE_CITY = 'opening_place_city';

    /** @var string */
    public const FIELD_OPENING_PLACE_COMPLEMENT = 'opening_place_complement';

    /** @var string */
    public const FIELD_OPENING_PLACE_NAME = 'opening_place_name';

    /** @var string */
    public const FIELD_OPENING_PLACE_NEIGHBORHOOD = 'opening_place_neighborhood';

    /** @var string */
    public const FIELD_OPENING_PLACE_NUMBER = 'opening_place_number';

    /** @var string */
    public const FIELD_OPENING_PLACE_STATE = 'opening_place_state';

    /** @var string */
    public const FIELD_OPENING_PLACE_ZIPCODE = 'opening_place_zipcode';

    /** @var string */
    public const FIELD_ORGANS_ID = 'organs_id';

    /** @var string */
    public const FIELD_PERSON_ORDERED_ID = 'person_ordered_id';

    /** @var string */
    public const FIELD_RESPONSIBLE_APPROVAL_ID = 'responsible_approval_id';

    /** @var string */
    public const FIELD_RESPONSIBLE_AWARD_ID = 'responsible_award_id';

    /** @var string */
    public const FIELD_RESPONSIBLE_INFORMATION_ID = 'responsible_information_id';

    /** @var string */
    public const FIELD_RESPONSIBLE_LEGAL_ADVICE_ID = 'responsible_legal_advice_id';

    /** @var string */
    public const FIELD_SLUG = 'slug';

    /** @var string */
    public const FIELD_STATUS = 'status';

    /** @var string */
    public const FIELD_TYPE = 'type';

    /** @var string */
    public const FIELD_UPPER_LIMITE_VALUE = 'upper_limite_value';

    /** @var string */
    public const FIELD_YEAR_OF_EXERCISE = 'year_of_exercise';

    public function addFilterById(string $operator, string ...$id): self;

    public function addFilterBySlug(string $operator, string ...$slug): self;

    public function addFilterByStatus(string $operator, Status ...$status): self;

    public function addOrderBy(string $field, string $direction): self;

    public function find(): Collection;

    public function getTotalItemsOfLastFindWithoutLimitations(): int;

    public function setLimit(int $limit): self;

    public function setOffset(int $offset): self;

    public function store(Bidding $bidding): string;
}
