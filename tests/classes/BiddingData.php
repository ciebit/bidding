<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Bidding;
use Ciebit\Bidding\Modality;
use Ciebit\Bidding\Place;
use Ciebit\Bidding\Status;
use Ciebit\Bidding\Type;
use Ciebit\Bidding\Year;
use DateTime;

class BiddingData
{
    public static function getData(): array
    {
        return [
            (new Bidding(
                new Year(2017),
                Modality::CONTEST(),
                Type::BEST_TECHNIQUE(),
                '123',
                '22',
                48754.45,
                50000.00,
                'Object Description 1',
                ['1', '2', '3'],
                new DateTime('2017-09-12'),
                new Place('Place 1', 'Address 1', '123', 'Neighborhood 1', 'Complement 1', 'City 1', 'Country 1', 61475000),
                new DateTime('2017-09-01'),
                '33',
                '44',
                '55',
                '66',
                '77',
                Status::CONTEST(),
                '1'
            ))->addFileId('1', '2', '3'),

            (new Bidding(
                new Year(2018),
                Modality::ELETRONIC_TRADING(),
                Type::LOWEST_PRICE(),
                '321',
                '32',
                789.20,
                1000.00,
                'Object Description 2',
                ['4', '5', '6'],
                new DateTime('2018-10-12'),
                new Place('Place 2', 'Address 2', '223', 'Neighborhood 2', 'Complement 2', 'City 2', 'Country 2', 62475000),
                new DateTime('2018-10-01'),
                '333',
                '444',
                '555',
                '666',
                '777',
                Status::DESERTED(),
                '2'
            ))->addFileId('4', '5', '6'),

            (new Bidding(
                new Year(2019),
                Modality::INVITATION_LETTER(),
                Type::TECHNIQUE_AND_PRICE(),
                '456',
                '42',
                2486.16,
                3500.00,
                'Object Description 3',
                ['7', '8', '9'],
                new DateTime('2019-05-12'),
                new Place('Place 3', 'Address 3', '333', 'Neighborhood 3', 'Complement 3', 'City 3', 'Country 3', 63475000),
                new DateTime('2019-05-01'),
                '3333',
                '4444',
                '5555',
                '6666',
                '7777',
                Status::OPEN(),
                '3'
            ))->addFileId('7', '8', '9')
        ];
    }
}
