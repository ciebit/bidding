<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Collection;
use Ciebit\Bidding\Tests\BiddingData;
use DateTime;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCreate(): void
    {
        $biddings = BiddingData::getData();
        $collection = new Collection(...$biddings);

        $this->assertEquals(3, $collection->count());
        $this->assertInstanceOf(ArrayObject::class, $collection->getArrayObject());
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
        $this->assertEquals($biddings[1], $collection->getById('2'));
        $this->assertEquals(range('1', '9'), $collection->getFilesId());
        $this->assertEquals(range('1', '9'), $collection->getOrgansId());
    }
}
