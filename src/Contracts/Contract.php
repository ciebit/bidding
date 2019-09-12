<?php
namespace Ciebit\Bidding\Contracts;

use DateTime;
use Ciebit\Bidding\Year;

use function array_push;

class Contract
{
    /** @var string */
    private $biddingId;

    /** @var DateTime */
    private $date;

    /** @var array */
    private $filesId;

    /** @var DateTime */
    private $finalDate;

    /** @var float */
    private $globalPrice;

    /** @var string */
    private $id;

    /** @var string */
    private $number;

    /** @var string */
    private $objectDescription;

    /** @var string */
    private $organId;

    /** @var string */
    private $personId;

    /** @var DateTime */
    private $startDate;

    /** @var Year */
    private $yearOfExercise;


    public function __construct(
        string $biddingId,
        Year $yearOfExercise,
        string $number,
        DateTime $date,
        DateTime $startDate,
        DateTime $finalDate,
        float $globalPrice,
        string $objectDescription,
        string $organId,
        string $personId,
        string $id = ''
    ) {
        $this->biddingId = $biddingId;
        $this->date = $date;
        $this->filesId = [];
        $this->finalDate = $finalDate;
        $this->globalPrice = $globalPrice;
        $this->id = $id;
        $this->number = $number;
        $this->objectDescription = $objectDescription;
        $this->organId = $organId;
        $this->personId = $personId;
        $this->startDate = $startDate;
        $this->yearOfExercise = $yearOfExercise;
    }

    public function addFileId(string ...$ids): self
    {
        array_push($this->filesId, ...$ids);
        return $this;
    }

    public function getBiddingId(): string
    {
        return $this->biddingId;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getFilesId(): array
    {
        return $this->filesId;
    }

    public function getFinalDate(): DateTime
    {
        return $this->finalDate;
    }

    public function getGlobalPrice(): float
    {
        return $this->globalPrice;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getObjectDescription(): string
    {
        return $this->objectDescription;
    }

    public function getOrganId(): string
    {
        return $this->organId;
    }

    public function getPersonId(): string
    {
        return $this->personId;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getYearOfExercise(): Year
    {
        return $this->yearOfExercise;
    }
}
