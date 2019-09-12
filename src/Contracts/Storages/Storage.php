<?php
namespace Ciebit\Bidding\Contracts\Storages;

use Ciebit\Bidding\Contracts\Collection;
use Ciebit\Bidding\Contracts\Contract;

interface Storage
{
    public function addFilterById(string $operator, string ...$id): self;

    public function find(): Collection;

    public function store(Contract $contract): string;
}
