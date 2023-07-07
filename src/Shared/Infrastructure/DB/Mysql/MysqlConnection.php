<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DB\Mysql;

use PDO;

class MysqlConnection
{
    private static ?PDO $conn;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    private function __destruct()
    {
        if (self::$conn !== null) {
            self::$conn = null;
        }
    }

    public static function getConnection(): ?PDO
    {
        $conn = null;

        try {
            $conn = new PDO(
                "mysql:host=app_mysql:3306" . ";dbname=" . getenv('MYSQL_DATABASE'),
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD')
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("set names utf8");
        } catch(\PDOException $e) {
            echo "MysqlConnection error: " . $e->getMessage();
        }

        self::$conn = $conn;

        return $conn;
    }
}
