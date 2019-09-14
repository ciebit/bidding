<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Storages\Database;

use Ciebit\Bidding\Collection;
use Ciebit\Bidding\Storages\Database\Sql;
use Ciebit\Bidding\Storages\Storage;
use Ciebit\Bidding\Tests\BuildPdo;
use Ciebit\Bidding\Tests\BiddingData;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('TRUNCATE TABLE `cb_bidding`');
        $pdo->exec('TRUNCATE TABLE `cb_bidding_files`');
        $pdo->exec('TRUNCATE TABLE `cb_bidding_organs_association`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    private function storeData(): void
    {
        $pdo = BuildPdo::build();
        $sql = new Sql($pdo);
        $biddings = BiddingData::getData();

        foreach($biddings as $bidding) {
            $sql->store($bidding);
        }
    }

    public function testStore(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $bidding = BiddingData::getData()[0];
        $id = $pdo->store($bidding);
        $this->assertIsString($id);
    }

    public function testFindById(): void
    {
        $this->storeData();
        $pdo = new Sql(BuildPdo::build());
        $bidding = BiddingData::getData()[0];
        $id = $bidding->getId();
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);
        $this->assertEquals($bidding, $collection->getById($id));
    }

    public function testFindOrderBy(): void
    {
        $this->storeData();
        $pdo = new Sql(BuildPdo::build());
        $bidding = BiddingData::getData()[2];
        $collection = $pdo->addOrderBy(Storage::FIELD_YEAR_OF_EXERCISE, 'DESC')->find();
        $this->assertEquals($bidding, $collection->getArrayObject()->offsetGet(0));
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
        $bidding = BiddingData::getData()[1];
        $this->assertEquals($bidding, $collection->getArrayObject()->offsetGet(0));
    }
}
