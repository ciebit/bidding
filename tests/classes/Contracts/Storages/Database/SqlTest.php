<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Contracts\Storages\Database;

use Ciebit\Bidding\Contracts\Collection;
use Ciebit\Bidding\Contracts\Contract;
use Ciebit\Bidding\Contracts\Storages\Database\Sql;
use Ciebit\Bidding\Tests\BuildPdo;
use Ciebit\Bidding\Tests\Contracts\ContractData;
use Ciebit\Bidding\Year;
use DateTime;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('TRUNCATE TABLE `cb_bidding_contracts`');
        $pdo->exec('TRUNCATE TABLE `cb_bidding_contracts_files`');
    }

    private function storeData(): void
    {
        $pdo = BuildPdo::build();
        $sql = new Sql($pdo);
        $contracts = ContractData::getData();

        foreach ($contracts as $contract) {
            $sql->store($contract);
        }
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    public function testStore(): void
    {
        $sql = new Sql(BuildPdo::build());
        $contract = ContractData::getData()[0];
        $id = $sql->store($contract);
        $collection = $sql->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);
        $this->assertEquals($contract, $collection->getArrayObject()->offsetGet(0));
    }

    public function testFindByBiddingId(): void
    {
        $this->storeData();
        $sql = new Sql(BuildPdo::build());
        $contract = ContractData::getData()[1];
        $id = $contract->getBiddingId();
        $collection = $sql->addFilterByBiddingId('=', $id)->find();
        $this->assertCount(1, $collection);
        $this->assertEquals($contract, $collection->getArrayObject()->offsetGet(0));
    }
}
