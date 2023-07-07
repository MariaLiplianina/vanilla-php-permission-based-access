<?php

declare(strict_types=1);

namespace App\Modules\Permission\Domain\Entity;

use App\Modules\User\Domain\Entity\Group;
use App\Modules\User\Domain\Entity\User;

class UserPermission
{
    private string $id;
    private ModulePermission $modulePermission;
    private ?Group $group = null;
    private ?User $user = null;

    public static function createUserPermission(
        string                                     $id,
        ModulePermission                           $modulePermission,
        ?Group $group = null,
        ?User  $user = null,
    ): self {
        $userPermission = new self();
        $userPermission->id = $id;
        $userPermission->modulePermission = $modulePermission;
        $userPermission->group = $group;
        $userPermission->user = $user;

        return $userPermission;
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getModulePermission(): ModulePermission
    {
        return $this->modulePermission;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
