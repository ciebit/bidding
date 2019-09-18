<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Contracts;

use Ciebit\Bidding\Contracts\Contract;
use Ciebit\Bidding\Year;
use DateTime;

class ContractData
{
    public static function getData(): array
    {
        return [
            (new Contract(
                '11', 
                new Year(2017), 
                '234', 
                new DateTime('2016-12-10'), 
                new DateTime('2017-01-01'), 
                new DateTime('2017-12-31'), 
                59872.0, 
                'Object Description 1', 
                '56', 
                '78', 
                '1'
            ))->addFileId('5'),

            (new Contract(
                '22', 
                new Year(2018), 
                '567', 
                new DateTime('2017-12-10'), 
                new DateTime('2018-01-01'), 
                new DateTime('2018-12-31'), 
                60452.5, 
                'Object Description 2', 
                '78', 
                '90', 
                '2')
            )->addFileId('6', '7'),

            new Contract(
                '33', 
                new Year(2019), 
                '890', 
                new DateTime('2018-12-10'), 
                new DateTime('2019-01-01'), 
                new DateTime('2019-12-31'), 
                62237.9, 
                'Object Description 3', 
                '90', 
                '65', 
                '3'
            )
        ];
    }
}
