<?php
namespace Ciebit\Bidding;

use MyCLabs\Enum\Enum;

class Modality extends Enum
{
    /** @var int */
    public const CONTEST = 1;

    /** @var int */
    public const ELECTRONIC_TRADING = 2;

    /** @var int */
    public const FACE_TRADING = 3;

    /** @var int */
    public const INVITATION_LETTER = 4;

    /** @var int */
    public const PRICE_MAKING = 5;

    /** @var int */
    public const PUBLIC_COMPETITION = 6;

    /**
     * Compatible
     */

    /** @var int */
    public const ELETRONIC_TRADING = Modality::ELECTRONIC_TRADING;
}