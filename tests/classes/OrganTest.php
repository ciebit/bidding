<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Organ;
use PHPUnit\Framework\TestCase;

class OrganTest extends TestCase
{
    /** @var string */
    private $id = '4444';

    /** @var string */
    private $name = 'Name';

    public function testCreate(): void
    {
        $organ = new Organ(
            $this->name,
            $this->id
        );

        $this->assertEquals($this->id, $organ->getId());
        $this->assertEquals($this->name, $organ->getName());
    }
}
