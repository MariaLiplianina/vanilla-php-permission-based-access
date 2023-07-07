<?php

declare(strict_types=1);

namespace App\Modules\Permission\Domain\Entity;

class Permission
{
    private string $id;
    private string $name;

    public static function createPermission(
        string $id,
        string $name,
    ): self {
        $module = new self();
        $module->id = $id;
        $module->name = $name;

        return $module;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
