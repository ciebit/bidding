<?php
namespace Ciebit\Bidding;

class Place
{
    /** @var string */
    private $address;

    /** @var string */
    private $city;

    /** @var string */
    private $complement;

    /** @var string */
    private $name;

    /** @var string */
    private $neighborhood;

    /** @var string */
    private $number;

    /** @var string */
    private $state;

    /** @var int */
    private $zipCode;

    public function __construct(
        string $name,
        string $address,
        string $number,
        string $neighborhood,
        string $complement,
        string $city,
        string $state,
        int $zipCode
    ) {
        $this->address = $address;
        $this->city = $city;
        $this->complement = $complement;
        $this->name = $name;
        $this->neighborhood = $neighborhood;
        $this->number = $number;
        $this->state = $state;
        $this->zipCode = $zipCode;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
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

    public function getState(): string
    {
        return $this->state;
    }

    public function getZipCode(): int
    {
        return $this->zipCode;
    }
}
