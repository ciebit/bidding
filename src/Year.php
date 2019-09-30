<?php
namespace Ciebit\Bidding;

class Year
{
    /** @var int */
    private $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function getInt(): int
    {
        return $this->number;
    }

    public function __toString(): string
    {
        return (string) $this->number;
    }
}