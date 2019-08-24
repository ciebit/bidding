<?php
namespace Ciebit\Bidding;

use MyCLabs\Enum\Enum;

class Type extends Enum
{
    /** @var int */
    public const BEST_TECHNIQUE = 1;

    /** @var int */
    public const LOWEST_PRICE = 2;

    /** @var int */
    public const TECHNIQUE_AND_PRICE = 3;
}