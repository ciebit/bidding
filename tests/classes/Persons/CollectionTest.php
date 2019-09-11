<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Persons;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Persons\Legal;
use Ciebit\Bidding\Persons\Collection;
use Ciebit\Bidding\Documents\Cnpj;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCreate(): void
    {
        $legalPersons = [
            new Legal('Name 01', new Cnpj('95.399.349/0001-54'), '1'),
            new Legal('Name 02', new Cnpj('95.399.349/0001-54'), '2'),
            new Legal('Name 03', new Cnpj('95.399.349/0001-54'), '3'),
        ];

        $collection = new Collection(...$legalPersons);

        $this->assertEquals(3, $collection->count());
        $this->assertInstanceOf(ArrayObject::class, $collection->getArrayObject());
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
        $this->assertEquals($legalPersons[1], $collection->getById('2'));
    }
}
