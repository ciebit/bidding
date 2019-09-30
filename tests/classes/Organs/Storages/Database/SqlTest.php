<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Organs\Storages\Database;

use Ciebit\Bidding\Organs\Collection;
use Ciebit\Bidding\Organs\Storages\Database\Sql;
use Ciebit\Bidding\Organs\Storages\Storage;
use Ciebit\Bidding\Tests\BuildPdo;
use Ciebit\Bidding\Tests\Organs\OrganData;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('TRUNCATE TABLE `cb_bidding_organs`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    private function storeData(): void
    {
        $pdo = BuildPdo::build();
        $sql = new Sql($pdo);
        $organs = OrganData::getData();

        foreach ($organs as $organ) {
            $sql->store($organ);
        }
    }

    public function testStore(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $organ = OrganData::getData()[0];
        $id = $pdo->store($organ);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);
        $this->assertEquals($organ, $collection->getArrayObject()->offsetGet(0));
    }

    public function testFindOrderBy(): void
    {
        $this->storeData();
        $pdo = new Sql(BuildPdo::build());
        $organ = OrganData::getData()[2];
        $collection = $pdo->addOrderBy(Storage::FIELD_NAME, 'DESC')->find();
        $this->assertEquals($organ, $collection->getArrayObject()->offsetGet(0));
    }

    public function testFindWithLimit(): void
    {
        $this->storeData();
        $pdo = new Sql(BuildPdo::build());
        $collection = $pdo->setLimit(2)->find();
        $this->assertCount(2, $collection);
    }

    public function testFindWithOffset(): void
    {
        $this->storeData();
        $pdo = new Sql(BuildPdo::build());
        $collection = $pdo->setOffset(1)->setLimit(3)->find();
        $organ = OrganData::getData()[1];
        $this->assertEquals($organ, $collection->getArrayObject()->offsetGet(0));
    }
}
