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

    public function getBiddingsId(): array
    {
        $ids = [];

        foreach ($this->getIterator() as $publication) {
            $ids[] = $publication->getBiddingId();
        }

        return $ids;
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

    public function getFilesId(): array
    {
        $ids = [];

        foreach ($this->getIterator() as $publication) {
            $ids[] = $publication->getFileId();
        }

        return $ids;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }
}