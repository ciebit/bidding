<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Committees\Storages\Database;

use Ciebit\Bidding\Committees\Collection;
use Ciebit\Bidding\Committees\Committee;
use Ciebit\Bidding\Committees\Storages\Database\Sql;
use Ciebit\Bidding\Tests\BuildPdo;
use DateTime;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('DELETE FROM `cb_bidding_committees`');
        $pdo->exec('DELETE FROM `cb_bidding_committees_members`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    public function testStoreAndFind(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $committee = new Committee('Name 01', new DateTime('2019-09-12'), '22', '33', ['44', '55']);
        $id = $pdo->store($committee);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);

        $committeeStorage = $collection->getById($id);
        $this->assertEquals($id, $committeeStorage->getId());
        $this->assertEquals($committee->getName(), $committeeStorage->getName());
        $this->assertEquals($committee->getDateCreation(), $committeeStorage->getDateCreation());
        $this->assertEquals($committee->getExternalId(), $committeeStorage->getExternalId());
        $this->assertEquals($committee->getManagerId(), $committeeStorage->getManagerId());
        $this->assertEquals($committee->getMembersId(), $committeeStorage->getMembersId());
    }
}
