<?php
namespace Ciebit\Bidding\Publications\Storages;

use Ciebit\Bidding\Publications\Collection;
use Ciebit\Bidding\Publications\Publication;

interface Storage
{
    public function addFilterById(string $operator, string ...$id): self;

    public function find(): Collection;

    public function store(Publication $publication): string;
}
