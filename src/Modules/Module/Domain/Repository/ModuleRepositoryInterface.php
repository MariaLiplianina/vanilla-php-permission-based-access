<?php

namespace App\Modules\Module\Domain\Repository;

use App\Modules\Module\Domain\Entity\Module;

interface ModuleRepositoryInterface
{
    public function save(Module $module): void;
    public function getByName(string $name): ?Module;
}
