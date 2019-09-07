<?php
namespace Ciebit\Bidding\Persons;

use Ciebit\Bidding\Documents\Cpf;
use Ciebit\Bidding\Documents\Document;
use Ciebit\Bidding\Persons\Person;

class Natural implements Person
{
    /** @var Cpf */
    private $cpf;
    
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $office;

    public function __construct(
        string $name,
        Cpf $cpf,
        string $office,
        string $id 
    ) {
        $this->cpf = $cpf;
        $this->id = $id;
        $this->name = $name;
        $this->office = $office;
    }

    public function getDocument(): Document
    {
        return $this->cpf;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOffice(): string
    {
        return $this->office;
    }
}
