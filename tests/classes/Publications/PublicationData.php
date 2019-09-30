<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Publications;

use Ciebit\Bidding\Publications\Publication;
use DateTime;

class PublicationData
{
    public static function getData(): array
    {
        return [
            new Publication(
                'Name 01',
                'Description 01',
                new DateTime('2019-09-11'),
                '11',
                '21',
                '1'
            ),
            new Publication(
                'Name 02',
                'Description 02',
                new DateTime('2019-09-12'),
                '12',
                '22',
                '2'
            ),
            new Publication(
                'Name 03',
                'Description 03',
                new DateTime('2019-09-13'),
                '13',
                '23',
                '3'
            ),
        ];
    }
}
