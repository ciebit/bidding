<?php
namespace Ciebit\Bidding\Committees;

use DateTime;

class Committee
{
    /** @var DateTime */
    private $dateCreation;

    /** @var string */
    private $externalId;

    /** @var string */
    private $id;

    /** @var string */
    private $managerId;

    /** @var array */
    private $membersId;

    /** @var string */
    private $name;

    public function __construct(
        string $name,
        DateTime $dateCreation,
        string $externalId,
        string $managerId,
        array $membersId,
        string $id = ''
    ) {
        $this->dateCreation = $dateCreation;
        $this->externalId = $externalId;
        $this->id = $id;
        $this->managerId = $managerId;
        $this->membersId = $membersId;
        $this->name = $name;
    }

    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getManagerId(): string
    {
        return $this->managerId;
    }

    public function getMembersId(): array
    {
        return $this->membersId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}