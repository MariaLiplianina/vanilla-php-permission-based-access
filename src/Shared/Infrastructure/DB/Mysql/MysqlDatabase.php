<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DB\Mysql;

use App\Shared\Infrastructure\DatabaseInterface;
use PDO;

final class MysqlDatabase implements DatabaseInterface
{
    public function getObjectOne(string $sql, string $className, array $params = []): mixed
    {
        $statement = $this->getPreparedStatement($sql, $params);

        $statement->setFetchMode(PDO::FETCH_CLASS, $className);

        $statement->execute();

        return $statement->fetch();
    }

    public function getSingleArrayResult(string $sql, array $params = []): array
    {
        $statement = $this->getPreparedStatement($sql, $params);

        $statement->setFetchMode(PDO::FETCH_ASSOC);

        $statement->execute();

        return $statement->fetch() ?: [];
    }

    public function getObjectList(string $sql, string $className, array $params = []): array
    {
        $statement = $this->getPreparedStatement($sql, $params);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function save(string $sql, array $params = []): void
    {
        $statement = $this->getPreparedStatement($sql, $params);

        $statement->execute($params);
    }

    private function getPreparedStatement(string $sql, array $params = []): \PDOStatement
    {
        $statement = MysqlConnection::getConnection()->prepare($sql);

        //multiple occurrences param binding
        foreach ($params as $paramName => $value) {
            if (str_contains($sql, $paramName)) {
                $occurrences = substr_count($sql, $paramName);

                for ($i = 0; $i < $occurrences; $i++) {
                    $statement->bindValue($paramName, $value);
                }
            }
        }

        return $statement;
    }
}
