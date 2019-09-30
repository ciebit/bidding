<?php
namespace Ciebit\Bidding\Publications;

use DateTime;

class Publication
{
    /** @var string */
    private $biddingId;

    /** @var DateTime */
    private $date;

    /** @var string */
    private $description;

    /** @var string */
    private $fileId;

    /** @var string */
    private $id;

    /** @var string */
    private $name;

    public function __construct(
        string $name,
        string $description,
        DateTime $date,
        string $biddingId,
        string $fileId,
        string $id = ''
    ) {
        $this->biddingId = $biddingId;
        $this->date = $date;
        $this->description = $description;
        $this->fileId = $fileId;
        $this->id = $id;
        $this->name = $name;
    }

    public function getBiddingId(): string
    {
        return $this->biddingId;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
