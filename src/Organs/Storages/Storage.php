<?php
namespace Ciebit\Bidding\Organs\Storages;

use Ciebit\Bidding\Organs\Collection;
use Ciebit\Bidding\Organs\Organ;

interface Storage
{
    /** @var string */
    public const FIELD_ID = 'id';

    /** @var string */
    public const FIELD_NAME = 'name';

    public function addFilterById(string $operator, string ...$id): self;

    public function find(): Collection;

    public function store(Organ $organ): string;
}
