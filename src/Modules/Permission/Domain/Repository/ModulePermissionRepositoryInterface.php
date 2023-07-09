<?php

namespace App\Modules\Permission\Domain\Repository;

use App\Modules\Permission\Domain\Entity\ModulePermission;

interface ModulePermissionRepositoryInterface
{
    public function save(ModulePermission $modulePermission): void;

    /**
     * @return array<int, ModulePermission>
     */
    public function getByModules(?string $moduleName = null, ?string $moduleFunctionName = null): array;
}
