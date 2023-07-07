<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

interface DatabaseInterface
{
    public function getObjectList(string $sql, string $className, array $params = []): array;
    public function getObjectOne(string $sql, string $className, array $params = []): mixed;
    public function getSingleArrayResult(string $sql, array $params = []): array;
    public function save(string $sql, array $params = []): void;
}
