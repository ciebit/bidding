<?php
namespace Ciebit\Bidding;

use MyCLabs\Enum\Enum;

class Status extends Enum
{
    /** @var int */
    public const ANNULLED = 1;

    /** @var int */
    public const CANCELED = 2;

    /** @var int */
    public const CONTEST = 3;

    /** @var int */
    public const DESERTED = 4;

    /** @var int */
    public const FAILED = 5;

    /** @var int */
    public const OPEN = 6;

    /** @var int */
    public const REPEALED = 7;
}