<?php

declare(strict_types=1);

namespace App\Modules\Module\Domain\Entity;

class Module
{
    private string $id;
    private string $name;

    public static function createModule(
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
