<?php
namespace Ciebit\Bidding\Publications\Storages;

use Ciebit\Bidding\Publications\Collection;
use Ciebit\Bidding\Publications\Publication;

interface Storage
{
    /** @var string */
    public const FIELD_BIDDING_ID = 'bidding_id';

    /** @var string */
    public const FIELD_DATE = 'date';

    /** @var string */
    public const FIELD_DESCRIPTION = 'description';

    /** @var string */
    public const FIELD_FILE_ID = 'file_id';

    /** @var string */
    public const FIELD_ID = 'id';

    /** @var string */
    public const FIELD_NAME = 'name';

    public function addFilterByBiddingId(string $operator, string ...$id): self;

    public function addFilterById(string $operator, string ...$id): self;

    public function find(): Collection;

    public function store(Publication $publication): string;
}
