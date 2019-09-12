<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Publications\Storages\Database;

use Ciebit\Bidding\Publications\Collection;
use Ciebit\Bidding\Publications\Publication;
use Ciebit\Bidding\Publications\Storages\Database\Sql;
use Ciebit\Bidding\Tests\BuildPdo;
use DateTime;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('DELETE FROM `cb_bidding_publications`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    public function testStoreAndFind(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $publication = new Publication('Name', 'Description', new DateTime('2019-09-11'), '22', '33');
        $id = $pdo->store($publication);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);

        $publicationStorage = $collection->getById($id);
        $this->assertEquals($id, $publicationStorage->getId());
        $this->assertEquals($publication->getName(), $publicationStorage->getName());
        $this->assertEquals($publication->getDescription(), $publicationStorage->getDescription());
        $this->assertEquals($publication->getDate(), $publicationStorage->getDate());
        $this->assertEquals($publication->getBiddingId(), $publicationStorage->getBiddingId());
        $this->assertEquals($publication->getFileId(), $publicationStorage->getFileId());
    }
}
