<?php
namespace Ciebit\Bidding\Organs;

class Organ
{
    /** @var string */
    private $name;

    /** @var string */
    private $id;

    public function __construct(
        string $name,
        string $id
    ) {
        $this->id = $id;
        $this->name = $name;
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