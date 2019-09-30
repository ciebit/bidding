<?php
namespace Ciebit\Bidding\Contracts;

use ArrayIterator;
use ArrayObject;
use Ciebit\Bidding\Contracts\Contract;
use Countable;
use IteratorAggregate;

use function array_merge;

class Collection implements Countable, IteratorAggregate
{
    /** @var ArrayObject */
    private $items;

    public function __construct(Contract ...$contracts)
    {
        $this->items = new ArrayObject;
        $this->add(...$contracts);
    }

    public function add(Contract ...$contracts): self
    {
        foreach($contracts as $contract) {
            $this->items->append($contract);
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

    public function getById(string $id): ?Contract
    {
        foreach ($this->getIterator() as $contract) {
            if ($contract->getId() == $id) {
                return $contract;
            }
        }

        return null;
    }

    public function getFilesId(): array
    {
        $ids = [];

        foreach ($this->getIterator() as $item) {
            $ids[] = $item->getFilesId();
        }

        return array_merge(...$ids);
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }

    public function getPersonsId(): array
    {
        $ids = [];

        foreach ($this->getIterator() as $item) {
            $ids[] = $item->getPersonId();
        }

        return $ids;
    }
}