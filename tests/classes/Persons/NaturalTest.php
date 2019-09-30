<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Persons;

use Ciebit\Bidding\Persons\Natural;
use Ciebit\Bidding\Documents\Cpf;
use PHPUnit\Framework\TestCase;

class NaturalTest extends TestCase
{
    /** @var Cpf */
    private $cpf;

    /** @var string */
    private $id = '1';

    /** @var string */
    private $name = 'Name';

    /** @var string */
    private $office = 'Office';

    public function __construct()
    {
        parent::__construct();

        $this->cpf = new Cpf('798.968.470-53');
    }

    public function testCreate(): void
    {
        $natural = new Natural(
            $this->name,
            $this->cpf,
            $this->office,
            $this->id
        );

        $this->assertEquals($this->cpf, $natural->getDocument());
        $this->assertEquals($this->id, $natural->getId());
        $this->assertEquals($this->name, $natural->getName());
        $this->assertEquals($this->office, $natural->getOffice());
    }
}
