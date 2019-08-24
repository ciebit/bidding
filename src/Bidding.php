<?php
namespace Ciebit\Bidding;

use Ciebit\Bidding\Modality;
use Ciebit\Bidding\Place;
use DateTime;

use function array_push;

class Bidding
{
    /** @var string */
    private $committeeId;

    /** @var double */
    private $estimatedBudgetAmount;

    /** @var array */
    private $filesId;

    /** @var string */
    private $id;

    /** @var Modality */
    private $modality;

    /** @var DateTime | null */
    private $noticePublicationDate;

    /** @var string */
    private $number;

    /** @var string */
    private $objectDescription;

    /** @var DateTime | null */
    private $openingDateTime;

    /** @var Place | null */
    private $openingPlace;

    /** @var array */
    private $orgainsId;

    /** @var string */
    private $personOrderedId;

    /** @var string */
    private $responsibleInformationId;

    /** @var string */
    private $responsibleLegalAdviceId;

    /** @var string */
    private $responsibleAwardId;

    /** @var string */
    private $responsibleApprovalId;

    /** @var Status */
    private $status;

    /** @var Type */
    private $type;

    /** @var double */
    private $upperLimitValue;

    /** @var int */
    private $yearOfExercise;

    public function __construct(
        int $yearOfExercise,
        Modality $modality,
        Type $type,
        string $number,
        string $committeeId,
        duuble $estimatedBudgetAmount,
        double $upperLimitValue,
        string $objectDescription,
        array $orgainsId,
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
        $this->number = $number;
        $this->objectDescription = $objectDescription;
        $this->orgainsId = $orgainsId;
        $this->personOrderedId = $personOrderedId;
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

    public function getEstimatedBudgetAmount(): double
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

    public function getNoticePublicationDate(): ?DateTime
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

    public function getOpeningDateTime(): ?DateTime
    {
        return $this->openingDateTime;
    }

    public function getOpeningPlace(): ?Place
    {
        return $this->openingPlace;
    }

    public function getOrgainsId(): array
    {
        return $this->orgainsId;
    }

    public function getPersonOrderedId(): string
    {
        return $this->personOrderedId;
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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getUpperLimitValue(): double
    {
        return $this->upperLimitValue;
    }

    public function getYearOfExercise(): int
    {
        return $this->yearOfExercise;
    }
}