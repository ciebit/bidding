<?php
namespace Ciebit\Bidding\Committees\Storages;

use Ciebit\Bidding\Committees\Collection;
use Ciebit\Bidding\Committees\Committee;

interface Storage
{
    public function addFilterById(string $operator, string ...$id): self;

    public function find(): Collection;

    public function store(Committee $committee): string;
}
