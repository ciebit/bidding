<?php
namespace Ciebit\Bidding\Publications;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Publications\Publication;
use Countable;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate
{
    /** @var ArrayObject */
    private $items;

    public function __construct(Publication ...$publications)
    {
        $this->items = new ArrayObject;
        $this->add(...$publications);
    }

    public function add(Publication ...$publications): self
    {
        foreach($publications as $publication) {
            $this->items->append($publication);
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

    public function getById(string $id): ?Publication
    {
        foreach ($this->getIterator() as $publication) {
            if ($publication->getId() == $id) {
                return $publication;
            }
        }

        return null;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }
}