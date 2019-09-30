<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Organs;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Organs\Collection;
use Ciebit\Bidding\Tests\Organs\OrganData;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCreate(): void
    {
        $organs = OrganData::getData();

        $collection = new Collection(...$organs);

        $this->assertEquals(3, $collection->count());
        $this->assertInstanceOf(ArrayObject::class, $collection->getArrayObject());
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
        $this->assertEquals($organs[1], $collection->getById('2'));
    }
}
