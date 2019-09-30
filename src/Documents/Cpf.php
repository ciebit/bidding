<?php
namespace Ciebit\Bidding\Documents;

use Bissolli\ValidadorCpfCnpj\CPF as BissoliCpf;
use Ciebit\Bidding\Documents\Document;
use InvalidArgumentException;

class Cpf implements Document
{
    /** @var BissoliCpf */
    private $number;

    public function __construct(string $number)
    {
        $this->number = new BissoliCpf($number);
        if (! $this->number->isValid()) {
            throw new InvalidArgumentException('ciebit.bidding.documents.cpf.invalid', 1);
        }
    }

    public function getFormat(): string
    {
        return $this->number->format();
    }

    public function getValue(): string
    {
        return $this->number->getValue();
    }

    public function __toString(): string
    {
        return $this->getFormat();
    }
}
