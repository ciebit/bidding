<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Year;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    /** @var int */
    private $year = 2019;

    public function testCreate(): void
    {
        $year = new Year($this->year);

        $this->assertEquals($this->year, $year->getInt());
        $this->assertEquals((string) $this->year, $year);
    }
}
