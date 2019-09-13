<?php
namespace Ciebit\Bidding\Storages;

use Ciebit\Bidding\Collection;
use Ciebit\Bidding\Bidding;

interface Storage
{
    public function addFilterById(string $operator, string ...$id): self;

    public function find(): Collection;

    public function store(Bidding $bidding): string;
}
