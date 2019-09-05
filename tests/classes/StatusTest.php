<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testCreate(): void
    {
        $this->assertInstanceOf(Status::class, Status::ANNULLED());
        $this->assertInstanceOf(Status::class, Status::CANCELED());
        $this->assertInstanceOf(Status::class, Status::CONTEST());
        $this->assertInstanceOf(Status::class, Status::DESERTED());
        $this->assertInstanceOf(Status::class, Status::FAILED());
        $this->assertInstanceOf(Status::class, Status::OPEN());
        $this->assertInstanceOf(Status::class, Status::REPEALED());
    }
}
