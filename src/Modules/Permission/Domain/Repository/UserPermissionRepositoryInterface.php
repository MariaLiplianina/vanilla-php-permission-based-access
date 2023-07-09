<?php

namespace App\Modules\Permission\Domain\Repository;

use App\Modules\Permission\Domain\Entity\UserPermission;

interface UserPermissionRepositoryInterface
{
    public function save(UserPermission $userPermission): void;
    public function getByUserAndFunction(string $username, string $moduleFunctionName): ?UserPermission;
}
