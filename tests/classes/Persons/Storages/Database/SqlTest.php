<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Persons\Storages\Database;

use Ciebit\Bidding\Documents\Cnpj;
use Ciebit\Bidding\Documents\Cpf;
use Ciebit\Bidding\Persons\Storages\Database\Sql;
use Ciebit\Bidding\Persons\Collection;
use Ciebit\Bidding\Persons\Legal;
use Ciebit\Bidding\Persons\Natural;
use Ciebit\Bidding\Tests\BuildPdo;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('DELETE FROM `cb_bidding_persons`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    public function testStoreAndFindNatural(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $person = new Natural('Name', new Cpf('632.424.150-51'), 'Office', '');
        $id = $pdo->store($person);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);

        $personStorage = $collection->getById($id);
        $this->assertEquals($id, $personStorage->getId());
        $this->assertEquals($person->getName(), $personStorage->getName());
        $this->assertEquals($person->getOffice(), $personStorage->getOffice());
        $this->assertEquals($person->getDocument(), $personStorage->getDocument());
    }

    public function testStoreAndFindLegal(): void
    {
        $person = new Legal('Name Legal', new Cnpj('62.089.619/0001-71'));
        $pdo = new Sql(BuildPdo::build());
        $id = $pdo->store($person);
        $personStorage = $pdo->addFilterById('=', $id)->find()->getById($id);
        $this->assertEquals($id, $personStorage->getId());
        $this->assertEquals($person->getName(), $personStorage->getName());
        $this->assertEquals($person->getDocument(), $personStorage->getDocument());
    }
}
