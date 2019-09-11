<?php
namespace Ciebit\Bidding\Organs;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Organs\Organ;
use Countable;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate
{
    /** @var ArrayObject */
    private $items;

    public function __construct(Organ ...$organs)
    {
        $this->items = new ArrayObject;
        $this->add(...$organs);
    }

    public function add(Organ ...$organs): self
    {
        foreach($organs as $organ) {
            $this->items->append($organ);
        }
        return $this;
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function getArrayObject(): ArrayObject
    {
        return clone $this->items;
    }

    public function getById(string $id): ?Organ
    {
        foreach ($this->getIterator() as $organ) {
            if ($organ->getId() == $id) {
                return $organ;
            }
        }

        return null;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }
}