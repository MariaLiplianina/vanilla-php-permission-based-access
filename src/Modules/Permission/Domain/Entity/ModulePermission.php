<?php

declare(strict_types=1);

namespace App\Modules\Permission\Domain\Entity;

use App\Modules\Module\Domain\Entity\Module;
use App\Modules\Module\Domain\Entity\ModuleFunction;

class ModulePermission
{
    private string $id;
    private Permission $permission;
    private ?Module $module = null;
    private ?ModuleFunction $moduleFunction = null;

    public static function createModulePermission(
        string         $id,
        Permission     $permission,
        Module         $module = null,
        ModuleFunction $moduleFunction = null,
    ): self {
        $modulePermission = new self();
        $modulePermission->id = $id;
        $modulePermission->permission = $permission;
        $modulePermission->module = $module;
        $modulePermission->moduleFunction = $moduleFunction;

        return $modulePermission;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPermission(): Permission
    {
        return $this->permission;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function getModuleFunction(): ?ModuleFunction
    {
        return $this->moduleFunction;
    }
}
