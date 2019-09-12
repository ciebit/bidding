<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Contracts;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Contracts\Collection;
use Ciebit\Bidding\Contracts\Contract;
use Ciebit\Bidding\Year;
use DateTime;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCreate(): void
    {
        $contracts = [
            new Contract('11', new Year(2017), '234', new DateTime('2016-12-10'), new DateTime('2017-01-01'), new DateTime('2017-12-31'), 59872.0, 'Object Description 1', '56', '78', '1'),
            new Contract('22', new Year(2018), '567', new DateTime('2017-12-10'), new DateTime('2018-01-01'), new DateTime('2018-12-31'), 60452.5, 'Object Description 2', '78', '90', '2'),
            new Contract('33', new Year(2019), '890', new DateTime('2018-12-10'), new DateTime('2019-01-01'), new DateTime('2019-12-31'), 62237.9, 'Object Description 3', '90', '65', '3'),
        ];

        $collection = new Collection(...$contracts);

        $this->assertEquals(3, $collection->count());
        $this->assertInstanceOf(ArrayObject::class, $collection->getArrayObject());
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
        $this->assertEquals($contracts[1], $collection->getById('2'));
    }
}
