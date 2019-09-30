<?php
namespace Ciebit\Bidding\Persons\Storages;

use Ciebit\Bidding\Persons\Collection;

interface Storage
{
    public function addFilterById(string $operator, string ...$id): self;

    public function find(): Collection;
}
