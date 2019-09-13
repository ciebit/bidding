<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Storages\Database;

use Ciebit\Bidding\Bidding;
use Ciebit\Bidding\Collection;
use Ciebit\Bidding\Modality;
use Ciebit\Bidding\Place;
use Ciebit\Bidding\Status;
use Ciebit\Bidding\Storages\Database\Sql;
use Ciebit\Bidding\Tests\BuildPdo;
use Ciebit\Bidding\Type;
use Ciebit\Bidding\Year;
use DateTime;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    private function setDatabaseDefault(): void
    {
        $pdo = BuildPdo::build();
        $pdo->exec('DELETE FROM `cb_bidding`');
        $pdo->exec('DELETE FROM `cb_bidding_files`');
        $pdo->exec('DELETE FROM `cb_bidding_organs_association`');
    }

    protected function setUp(): void
    {
        $this->setDatabaseDefault();
    }

    public function testStoreAndFind(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $bidding = new Bidding(
                new Year(2017),
                Modality::CONTEST(),
                Type::BEST_TECHNIQUE(),
                '123',
                '22',
                48754.45,
                50000.00,
                'Object Description 1',
                ['1', '2', '3'],
                new DateTime('2017-09-12'),
                new Place('Place', 'Address', '223', 'Neighborhood', 'Complement', 'City', 'Country', 62475000),
                new DateTime('2017-09-01'),
                '33',
                '44',
                '55',
                '66',
                '77',
                Status::CONTEST(),
                '1'
        );
        $bidding->addFileId('9', '8', '7');
        $id = $pdo->store($bidding);
        $collection = $pdo->addFilterById('=', $id)->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);

        $biddingStorage = $collection->getById($id);
        $this->assertEquals($id, $biddingStorage->getId());
        $this->assertEquals($bidding->getCommitteeId(), $biddingStorage->getCommitteeId());
        $this->assertEquals($bidding->getEstimatedBudgetAmount(), $biddingStorage->getEstimatedBudgetAmount());
        $this->assertEquals($bidding->getFilesId(), $biddingStorage->getFilesId());
        $this->assertEquals($bidding->getYearOfExercise(), $biddingStorage->getYearOfExercise());
        $this->assertEquals($bidding->getModality(), $biddingStorage->getModality());
        $this->assertEquals($bidding->getType(), $biddingStorage->getType());
        $this->assertEquals($bidding->getNumber(), $biddingStorage->getNumber());
    }
}
