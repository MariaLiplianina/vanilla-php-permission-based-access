<?php

namespace App\Modules\Module\Domain\Repository;

use App\Modules\Module\Domain\Entity\ModuleFunction;

interface ModuleFunctionRepositoryInterface
{
    public function save(ModuleFunction $moduleFunction): void;
}
