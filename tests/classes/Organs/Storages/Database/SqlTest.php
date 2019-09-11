<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Organs\Storages\Database;

use Ciebit\Bidding\Organs\Collection;
use Ciebit\Bidding\Organs\Organ;
use Ciebit\Bidding\Organs\Storages\Database\Sql;
use Ciebit\Bidding\Tests\BuildPdo;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('DELETE FROM `cb_bidding_organs`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    public function testStoreAndFind(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $organ = new Organ('Name', '');
        $id = $pdo->store($organ);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);

        $personStorage = $collection->getById($id);
        $this->assertEquals($id, $personStorage->getId());
        $this->assertEquals($organ->getName(), $personStorage->getName());
    }
}
