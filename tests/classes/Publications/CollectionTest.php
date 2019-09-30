<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Publications;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Publications\Collection;
use Ciebit\Bidding\Tests\Publications\PublicationData;
use PHPUnit\Framework\TestCase;

use function count;

class CollectionTest extends TestCase
{
    public function testCreate(): void
    {
        $publications = PublicationData::getData();

        $collection = new Collection(...$publications);

        $this->assertCount(count($publications), $collection);
        $this->assertInstanceOf(ArrayObject::class, $collection->getArrayObject());
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
        $this->assertEquals($publications[1], $collection->getById('2'));
        $this->assertEquals(range('11', '13'), $collection->getBiddingsId());
        $this->assertEquals(range('21', '23'), $collection->getFilesId());
    }
}
