<?php
namespace Ciebit\Bidding;

use MyCLabs\Enum\Enum;

class Type extends Enum
{
    /** @var int */
    public const BEST_TECHNIQUE = 1;

    /** @var int */
    public const BIGGEST_DISCOUNT = 6;

    /** @var int */
    public const LOWEST_PRICE = 2;

    /** @var int  */
    public const LOWEST_PRICE_AND_BIGGEST_DISCOUNT = 7;

    /** @var int */
    public const OPEN = 4;

    /** @var int */
    public const OPEN_AND_CLOSED = 5;

    /** @var int */
    public const TECHNIQUE_AND_PRICE = 3;
}