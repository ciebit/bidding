<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Committees;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Committees\Committee;
use Ciebit\Bidding\Committees\Collection;
use DateTime;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCreate(): void
    {
        $committees = [
            new Committee('Name 01', new DateTime('2019-09-01'), '11', '12', ['13', '14', '15'], '1'),
            new Committee('Name 02', new DateTime('2019-09-02'), '21', '22', ['16', '17', '18'], '2'),
            new Committee('Name 03', new DateTime('2019-09-03'), '31', '32', ['19', '20', '21'], '3'),
        ];

        $collection = new Collection(...$committees);

        $this->assertEquals(3, $collection->count());
        $this->assertInstanceOf(ArrayObject::class, $collection->getArrayObject());
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
        $this->assertEquals($committees[1], $collection->getById('2'));
        $this->assertEquals(range('13', '21'), $collection->getMembersId());
    }
}
