<?php
namespace Ciebit\Bidding\Persons;

use Ciebit\Bidding\Documents\Cnpj;
use Ciebit\Bidding\Documents\Document;
use Ciebit\Bidding\Persons\Person;

class Legal implements Person
{
    /** @var Cnpj */
    private $cnpj;
    
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    public function __construct(
        string $name,
        Cnpj $cnpj,
        string $id 
    ) {
        $this->cnpj = $cnpj;
        $this->id = $id;
        $this->name = $name;
    }

    public function getDocument(): Document
    {
        return $this->cnpj;
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
