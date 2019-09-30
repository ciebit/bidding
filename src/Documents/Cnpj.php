<?php
namespace Ciebit\Bidding\Documents;

use Bissolli\ValidadorCpfCnpj\CNPJ as BissoliCnpj;
use Ciebit\Bidding\Documents\Document;
use InvalidArgumentException;

class Cnpj implements Document
{
    /** @var BissoliCnpj */
    private $number;

    public function __construct(string $number)
    {
        $this->number = new BissoliCnpj($number);
        if (! $this->number->isValid()) {
            throw new InvalidArgumentException('ciebit.bidding.documents.cnpj.invalid', 1);
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
