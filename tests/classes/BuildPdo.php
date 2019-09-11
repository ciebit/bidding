<?php
declare(strict_types=1);

namespace Ciebit\Bidding\Tests;

use PDO;

class BuildPdo
{
    /** @var PDO */
    private static $pdo;

    private function getData(): array
    {
        $settings = include __DIR__ . '/../settings.php';
        return $settings['database'];
    }

    public static function build(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $data = self::getData();

        $dsn = "mysql:dbname={$data['name']};"
            . "host={$data['host']};"
            . "port={$data['port']};"
            . "charset={$data['charset']}";

        return self::$pdo = new PDO($dsn, $data['user'], $data['password']);
    }
}
