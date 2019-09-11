<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests\Persons\Storages\Database;

use Ciebit\Bidding\Persons\Storages\Database\Sql;
use Ciebit\Bidding\Persons\Collection;
use Ciebit\Bidding\Tests\BuildPdo;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    public function testFind(): void
    {
        $pdo = new Sql(BuildPdo::build());
        $collection = $pdo->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(0, $collection);
    }
}
