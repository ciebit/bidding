<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Contracts;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Contracts\Collection;
use Ciebit\Bidding\Tests\Contracts\ContractData;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCreate(): void
    {
        $contracts = ContractData::getData();

        $collection = new Collection(...$contracts);

        $this->assertEquals(3, $collection->count());
        $this->assertInstanceOf(ArrayObject::class, $collection->getArrayObject());
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
        $this->assertEquals($contracts[1], $collection->getById('2'));
        $this->assertEquals(range('5', '7'), $collection->getFilesId());
        $this->assertEquals(range('78', '80'), $collection->getPersonsId());
    }

    public function testGetFilesIdNotValue(): void
    {
        $contract = ContractData::getData()[2];
        $collection = new Collection($contract);
        $this->assertEquals([], $collection->getFilesId());
    }
}
