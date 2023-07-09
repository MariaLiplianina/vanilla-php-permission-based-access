<?php

namespace App\Modules\Permission\Domain\Repository;

use App\Modules\Permission\Domain\Entity\Permission;

interface PermissionRepositoryInterface
{
    public function save(Permission $permission): void;
    public function getByName(string $name): ?Permission;
}
