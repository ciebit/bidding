<?php
namespace Ciebit\Bidding;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Bidding;
use Countable;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate
{
    /** @var ArrayObject */
    private $items;

    public function __construct(Bidding ...$biddings)
    {
        $this->items = new ArrayObject;
        $this->add(...$biddings);
    }

    public function add(Bidding ...$biddings): self
    {
        foreach($biddings as $bidding) {
            $this->items->append($bidding);
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

    public function getById(string $id): ?Bidding
    {
        foreach ($this->getIterator() as $bidding) {
            if ($bidding->getId() == $id) {
                return $bidding;
            }
        }

        return null;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }
}