<?php

declare(strict_types=1);

namespace App\Modules\Permission\Application;

use App\Modules\Permission\Domain\Repository\UserPermissionRepositoryInterface;

class PermissionService
{
    public function __construct(private readonly UserPermissionRepositoryInterface $userPermissionRepository)
    {
    }

    public function hasPermission(string $userName, string $moduleFunction): bool
    {
        $result = $this->userPermissionRepository->getByUserAndFunction($userName, $moduleFunction);

        return !empty($result);
    }
}
