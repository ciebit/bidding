<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Persons;

use Ciebit\Bidding\Persons\Legal;
use Ciebit\Bidding\Documents\Cnpj;
use PHPUnit\Framework\TestCase;

class LegalTest extends TestCase
{
    /** @var Cnpj */
    private $cnpj;

    /** @var string */
    private $id = '1';

    /** @var string */
    private $name = 'Name';

    public function __construct()
    {
        parent::__construct();

        $this->cnpj = new Cnpj('95.399.349/0001-54');
    }

    public function testCreate(): void
    {
        $legal = new Legal(
            $this->name,
            $this->cnpj,
            $this->id
        );

        $this->assertEquals($this->cnpj, $legal->getDocument());
        $this->assertEquals($this->id, $legal->getId());
        $this->assertEquals($this->name, $legal->getName());
    }
}
