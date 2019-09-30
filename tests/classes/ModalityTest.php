<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use Ciebit\Bidding\Modality;
use PHPUnit\Framework\TestCase;

class ModalityTest extends TestCase
{
    public function testCreate(): void
    {
        $this->assertInstanceOf(Modality::class, Modality::CONTEST());
        $this->assertInstanceOf(Modality::class, Modality::ELETRONIC_TRADING());
        $this->assertInstanceOf(Modality::class, Modality::FACE_TRADING());
        $this->assertInstanceOf(Modality::class, Modality::INVITATION_LETTER());
        $this->assertInstanceOf(Modality::class, Modality::PRICE_MAKING());
        $this->assertInstanceOf(Modality::class, Modality::PUBLIC_COMPETITION());
    }
}
