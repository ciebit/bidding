<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Documents;

use Ciebit\Bidding\Documents\Cnpj;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function str_replace;

class CnpjTest extends TestCase
{
    /** @var string */
    private $number = '29.739.562/0001-33';

    public function testCreate(): void
    {
        $cnpj = new Cnpj($this->number);

        $this->assertEquals(str_replace(['.', '-', '/'], '', $this->number), $cnpj->getValue());
        $this->assertEquals($this->number, $cnpj->getFormat());
    }


    public function testCreateInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Cnpj('12.345.567/0008-90');
    }
}
