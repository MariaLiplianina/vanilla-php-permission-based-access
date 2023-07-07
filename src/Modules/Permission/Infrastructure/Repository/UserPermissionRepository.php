<?php

declare(strict_types=1);

namespace App\Modules\Permission\Infrastructure\Repository;

use App\Modules\Permission\Domain\Entity\UserPermission;
use App\Shared\Infrastructure\DatabaseInterface;

class UserPermissionRepository
{

    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    public function save(UserPermission $permission): void
    {
        $sql = "INSERT INTO `user_permission`
                    (`id`, `module_permission_id`, `group_id`, `user_id`) 
                VALUES (:id, :module_permission_id, :group_id, :user_id)";

        $this->database->save($sql, [
            ':id' => $permission->getId(),
            ':module_permission_id' => $permission->getModulePermission()->getId(),
            ':group_id' => $permission->getGroup()?->getId(),
            ':user_id' => $permission->getUser()?->getId(),
        ]);
    }

    public function getByUserAndFunction(string $username, string $moduleFunctionName): array
    {
        $sql = "SELECT up.* 
                FROM `user` u 
                JOIN `group` g 
                    ON u.group_id = g.id 
                LEFT JOIN `user_permission` up
                    ON (up.user_id = u.id OR up.group_id = g.id)
                JOIN `module_permission` mp
                    ON (up.module_permission_id  = mp.id)
                LEFT JOIN `module` m 
                    ON mp.module_id = m.id
                LEFT JOIN `module_function` mf 
                    ON mp.module_function_id = mf.id
                LEFT JOIN `module_function` mf2 
                    ON (mf2.module_id = m.id AND mf2.name = :mf_name)
                WHERE u.name = :u_name 
                  AND (mf.name = :mf_name OR mf2.name = :mf_name)
        ;";

        return $this->database->getSingleArrayResult($sql, [
            ':u_name' => $username,
            ':mf_name' => $moduleFunctionName,
        ]);
    }
}
