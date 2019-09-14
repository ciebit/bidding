<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Organs;

use Ciebit\Bidding\Organs\Organ;

class OrganData
{
    public static function getData(): array
    {
        return [
            new Organ('Name 01', '1'),
            new Organ('Name 02', '2'),
            new Organ('Name 03', '3'),
        ];
    }
}
