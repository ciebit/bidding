<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Contracts\Storages\Database;

use Ciebit\Bidding\Contracts\Collection;
use Ciebit\Bidding\Contracts\Contract;
use Ciebit\Bidding\Contracts\Storages\Database\Sql;
use Ciebit\Bidding\Tests\BuildPdo;
use Ciebit\Bidding\Year;
use DateTime;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('DELETE FROM `cb_bidding_contracts`');
        $pdo->exec('DELETE FROM `cb_bidding_contracts_files`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    public function testStoreAndFind(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $contract = new Contract('11', new Year(2017), '234', new DateTime('2016-12-10'), new DateTime('2017-01-01'), new DateTime('2017-12-31'), 59872.0, 'Object Description 1', '56', '78', '1');
        $contract->addFileId('22', '33', '44');
        $id = $pdo->store($contract);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);

        $Contractstorage = $collection->getById($id);
        $this->assertEquals($id, $Contractstorage->getId());
        $this->assertEquals($contract->getBiddingId(), $Contractstorage->getBiddingId());
        $this->assertEquals($contract->getDate(), $Contractstorage->getDate());
        $this->assertEquals($contract->getFilesId(), $Contractstorage->getFilesId());
        $this->assertEquals($contract->getFinalDate(), $Contractstorage->getFinalDate());
        $this->assertEquals($contract->getGlobalPrice(), $Contractstorage->getGlobalPrice());
        $this->assertEquals($contract->getNumber(), $Contractstorage->getNumber());
        $this->assertEquals($contract->getObjectDescription(), $Contractstorage->getObjectDescription());
        $this->assertEquals($contract->getOrganId(), $Contractstorage->getOrganId());
        $this->assertEquals($contract->getPersonId(), $Contractstorage->getPersonId());
        $this->assertEquals($contract->getStartDate(), $Contractstorage->getStartDate());
        $this->assertEquals($contract->getYearOfExercise(), $Contractstorage->getYearOfExercise());
    }
}
