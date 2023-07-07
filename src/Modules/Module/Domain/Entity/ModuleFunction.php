<?php

declare(strict_types=1);

namespace App\Modules\Module\Domain\Entity;

class ModuleFunction
{
    private string $id;

    private string $name;

    private Module $module;

    public static function createModuleFunction(
        string $id,
        string $name,
        Module $module
    ): self {
        $moduleFunction = new self();
        $moduleFunction->id = $id;
        $moduleFunction->name = $name;
        $moduleFunction->module = $module;

        return $moduleFunction;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModule(): Module
    {
        return $this->module;
    }
}
