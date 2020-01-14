<?php
namespace Ciebit\Bidding;

use Ciebit\Bidding\Modality;
use Ciebit\Bidding\Place;
use Ciebit\Bidding\Year;
use DateTime;

use function array_push;

class Bidding
{
    /** @var string */
    private $committeeId;

    /** @var float */
    private $estimatedBudgetAmount;

    /** @var array */
    private $filesId;

    /** @var string */
    private $id;

    /** @var Modality */
    private $modality;

    /** @var DateTime */
    private $noticePublicationDate;

    /** @var string */
    private $number;

    /** @var string */
    private $objectDescription;

    /** @var DateTime */
    private $openingDateTime;

    /** @var Place */
    private $openingPlace;

    /** @var array */
    private $organsId;

    /** @var string */
    private $personOrderedId;

    /** @var DateTime */
    private $reopeningDateTime;

    /** @var string */
    private $responsibleInformationId;

    /** @var string */
    private $responsibleLegalAdviceId;

    /** @var string */
    private $responsibleAwardId;

    /** @var string */
    private $responsibleApprovalId;

    /** @var string */
    private $slug;

    /** @var Status */
    private $status;

    /** @var Type */
    private $type;

    /** @var float */
    private $upperLimitValue;

    /** @var Year */
    private $yearOfExercise;

    public function __construct(
        Year $yearOfExercise,
        Modality $modality,
        Type $type,
        string $number,
        string $slug,
        string $committeeId,
        float $estimatedBudgetAmount,
        float $upperLimitValue,
        string $objectDescription,
        array $organsId,
        DateTime $openingDateTime,
        Place $openingPlace,
        DateTime $noticePublicationDate,
        DateTime $reopeningDateTime = null,
        string $personOrderedId,
        string $responsibleInformationId,
        string $responsibleLegalAdviceId,
        string $responsibleAwardId,
        string $responsibleApprovalId,
        Status $status,
        string $id = ''
    ) {
        $this->committeeId = $committeeId;
        $this->estimatedBudgetAmount = $estimatedBudgetAmount;
        $this->filesId = [];
        $this->id = $id;
        $this->modality = $modality;
        $this->noticePublicationDate = $noticePublicationDate;
        $this->number = $number;
        $this->slug = $slug;
        $this->objectDescription = $objectDescription;
        $this->openingDateTime = $openingDateTime;
        $this->openingPlace = $openingPlace;
        $this->organsId = $organsId;
        $this->personOrderedId = $personOrderedId;
        $this->reopeningDateTime = $reopeningDateTime;
        $this->responsibleInformationId = $responsibleInformationId;
        $this->responsibleLegalAdviceId = $responsibleLegalAdviceId;
        $this->responsibleAwardId = $responsibleAwardId;
        $this->responsibleApprovalId = $responsibleApprovalId;
        $this->status = $status;
        $this->type = $type;
        $this->upperLimitValue = $upperLimitValue;
        $this->yearOfExercise = $yearOfExercise;
    }

    public function addFileId(string ...$ids): self
    {
        array_push($this->filesId, ...$ids);
        return $this;
    }

    public function getCommitteeId(): string
    {
        return $this->committeeId;
    }

    public function getEstimatedBudgetAmount(): float
    {
        return $this->estimatedBudgetAmount;
    }

    public function getFilesId(): array
    {
        return $this->filesId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getModality(): Modality
    {
        return $this->modality;
    }

    public function getNoticePublicationDate(): DateTime
    {
        return $this->noticePublicationDate;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getObjectDescription(): string
    {
        return $this->objectDescription;
    }

    public function getOpeningDateTime(): DateTime
    {
        return $this->openingDateTime;
    }

    public function getOpeningPlace(): Place
    {
        return $this->openingPlace;
    }

    public function getOrgansId(): array
    {
        return $this->organsId;
    }

    public function getPersonOrderedId(): string
    {
        return $this->personOrderedId;
    }

    public function getReopeningDateTime(): ?DateTime
    {
        return $this->reopeningDateTime;
    }

    public function getResponsibleInformationId(): string
    {
        return $this->responsibleInformationId;
    }

    public function getResponsibleLegalAdviceId(): string
    {
        return $this->responsibleLegalAdviceId;
    }

    public function getResponsibleAwardId(): string
    {
        return $this->responsibleAwardId;
    }

    public function getResponsibleApprovalId(): string
    {
        return $this->responsibleApprovalId;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getUpperLimitValue(): float
    {
        return $this->upperLimitValue;
    }

    public function getYearOfExercise(): Year
    {
        return $this->yearOfExercise;
    }
}