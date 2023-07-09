<?php

declare(strict_types=1);

namespace App\Modules\Permission\Infrastructure\Repository;

use App\Modules\Permission\Domain\Entity\ModulePermission;
use App\Modules\Permission\Domain\Repository\ModulePermissionRepositoryInterface;
use App\Shared\Infrastructure\DatabaseInterface;
use http\Exception\InvalidArgumentException;

class ModulePermissionRepository implements ModulePermissionRepositoryInterface
{
    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    public function save(ModulePermission $permission): void
    {
        $sql = "INSERT INTO `module_permission`
                    (`id`, `permission_id`, `module_id`, `module_function_id`) 
                VALUES (:id, :permission_id, :module_id, :module_function_id)";

        $this->database->save($sql, [
            ':id' => $permission->getId(),
            ':permission_id' => $permission->getPermission()->getId(),
            ':module_id' => $permission->getModule()?->getId(),
            ':module_function_id' => $permission->getModuleFunction()?->getId(),
        ]);
    }


    /**
     * @param string|null $moduleName
     * @param string|null $moduleFunctionName
     * @return array<int, ModulePermission>
     */
    public function getByModules(?string $moduleName = null, ?string $moduleFunctionName = null): array
    {
        if (!isset($moduleName)  && !isset($moduleFunctionName)) {
            throw new InvalidArgumentException("Module name or ModuleFunction name should be provided");
        }

        $sql = "SELECT mp.* 
                FROM `module_permission` mp
                LEFT JOIN module m 
                    ON mp.module_id = m.id
                LEFT JOIN module_function mf 
                    ON mp.module_function_id = mf.id
                WHERE m.`name` = :module_name
                    OR mf.`name` = :module_function_name
        ;";

        return $this->database->getObjectList($sql, ModulePermission::class, [
            ':module_name' => $moduleName,
            ':module_function_name' => $moduleFunctionName,
        ]) ?: [];
    }
}
