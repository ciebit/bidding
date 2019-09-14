<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Publications\Storages\Database;

use Ciebit\Bidding\Publications\Collection;
use Ciebit\Bidding\Publications\Storages\Database\Sql;
use Ciebit\Bidding\Tests\BuildPdo;
use Ciebit\Bidding\Tests\Publications\PublicationData;
use DateTime;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('TRUNCATE TABLE `cb_bidding_publications`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    private function storeData(): void
    {
        $pdo = BuildPdo::build();
        $sql = new Sql($pdo);
        $publications = PublicationData::getData();

        foreach ($publications as $publication) {
            $sql->store($publication);
        }
    }

    public function testStore(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $publication = PublicationData::getData()[0];
        $id = $pdo->store($publication);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);
        $this->assertEquals($publication, $collection->getArrayObject()->offsetGet(0));
    }

    public function testFindByBiddingId(): void
    {
        $this->storeData();
        $pdo = new Sql(BuildPdo::build());
        $publication = PublicationData::getData()[1];
        $id = $publication->getBiddingId();
        $collection = $pdo->addFilterByBiddingId('=', $id)->find();
        $this->assertCount(1, $collection);
        $this->assertEquals($publication, $collection->getArrayObject()->offsetGet(0));
    }
}
