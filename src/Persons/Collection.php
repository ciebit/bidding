<?php
namespace Ciebit\Bidding\Persons;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Persons\Person;
use Countable;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate
{
    /** @var ArrayObject */
    private $items;

    public function __construct(Person ...$persons)
    {
        $this->items = new ArrayObject;
        $this->add(...$persons);
    }

    public function add(Person ...$persons): self
    {
        foreach($persons as $person) {
            $this->items->append($person);
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

    public function getById(string $id): ?Person
    {
        foreach ($this->getIterator() as $person) {
            if ($person->getId() == $id) {
                return $person;
            }
        }

        return null;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }
}