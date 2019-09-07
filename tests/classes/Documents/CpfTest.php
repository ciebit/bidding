<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Documents;

use Ciebit\Bidding\Documents\Cpf;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function str_replace;

class CpfTest extends TestCase
{
    /** @var string */
    private $number = '039.092.940-90';

    public function testCreate(): void
    {
        $cpf = new Cpf($this->number);

        $this->assertEquals(str_replace(['.', '-'], '', $this->number), $cpf->getValue());
        $this->assertEquals($this->number, $cpf->getFormat());
    }

    public function testCreateInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Cpf('12.345.567-89');
    }
}
