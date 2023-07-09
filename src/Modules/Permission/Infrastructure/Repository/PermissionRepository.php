<?php

declare(strict_types=1);

namespace App\Modules\Permission\Infrastructure\Repository;

use App\Modules\Permission\Domain\Entity\Permission;
use App\Modules\Permission\Domain\Repository\PermissionRepositoryInterface;
use App\Shared\Infrastructure\DatabaseInterface;

class PermissionRepository implements PermissionRepositoryInterface
{

    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    public function save(Permission $permission): void
    {
        $sql = "INSERT INTO permission (id, name) VALUES (:id, :name)";

        $this->database->save($sql, [
            ':id' => $permission->getId(),
            ':name' => $permission->getName(),
        ]);
    }

    public function getByName(string $name): ?Permission
    {
        $sql = "SELECT `permission`.* FROM `permission` WHERE `name` = :name;";

        return $this->database->getObjectOne($sql, Permission::class, [':name' => $name]) ?: null;
    }
}
