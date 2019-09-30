<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Type;
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{
    public function testCreate(): void
    {
        $this->assertInstanceOf(Type::class, Type::BEST_TECHNIQUE());
        $this->assertInstanceOf(Type::class, Type::LOWEST_PRICE());
        $this->assertInstanceOf(Type::class, Type::TECHNIQUE_AND_PRICE());
    }
}
