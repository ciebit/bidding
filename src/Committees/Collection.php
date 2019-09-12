<?php
namespace Ciebit\Bidding\Committees;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Committees\Committee;
use Countable;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate
{
    /** @var ArrayObject */
    private $items;

    public function __construct(Committee ...$committees)
    {
        $this->items = new ArrayObject;
        $this->add(...$committees);
    }

    public function add(Committee ...$committees): self
    {
        foreach($committees as $committee) {
            $this->items->append($committee);
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

    public function getById(string $id): ?Committee
    {
        foreach ($this->getIterator() as $committee) {
            if ($committee->getId() == $id) {
                return $committee;
            }
        }

        return null;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }
}