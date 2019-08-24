<?php
namespace Ciebit\Bidding;

class Place
{
    /** @var string */
    private $address;

    /** @var string */
    private $complement;

    /** @var string */
    private $name;

    /** @var string */
    private $neighborhood;

    /** @var string */
    private $number;

    /** @var int */
    private $zipCode;

    public function __construct(
        string $name,
        string $address,
        string $complement,
        string $neighborhood,
        string $number,
        int $zipCode
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->complement = $complement;
        $this->neighborhood = $neighborhood;
        $this->number = $number;
        $this->zipCode = $zipCode;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getComplement(): string
    {
        return $this->complement;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getZipCode(): int
    {
        return $this->zipCode;
    }
}
