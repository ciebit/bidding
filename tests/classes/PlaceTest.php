<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Place;
use PHPUnit\Framework\TestCase;

class PlaceTest extends TestCase
{
    /** @var string */
    public const ADDRESS = 'Rua Sigefredo Diógenes';

    /** @var string */
    public const COMPLEMENT = 'Near the bus station';

    /** @var string */
    public const NAME = 'Dojo ASKAJA';

    /** @var string */
    public const NEIGHBORHOOD = 'Centro';

    /** @var string */
    public const NUMBER = 'S/N';

    /** @var int */
    public const ZIP_CODE = 63475000;

    
    public function testCreate(): void
    {
        $place = new Place(
            self::NAME, 
            self::ADDRESS, 
            self::COMPLEMENT, 
            self::NEIGHBORHOOD, 
            self::NUMBER, 
            self::ZIP_CODE
        );

        $this->assertEquals(self::ADDRESS, $place->getAddress());
        $this->assertEquals(self::COMPLEMENT, $place->getComplement());
        $this->assertEquals(self::NEIGHBORHOOD, $place->getNeighborhood());
        $this->assertEquals(self::NAME, $place->getName());
        $this->assertEquals(self::NUMBER, $place->getNumber());
        $this->assertEquals(self::ZIP_CODE, $place->getZipCode());
    }
}
