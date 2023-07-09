<?php

declare(strict_types=1);

namespace App\Modules\Module\Infrastructure\Repository;

use App\Modules\Module\Domain\Entity\ModuleFunction;
use App\Modules\Module\Domain\Repository\ModuleFunctionRepositoryInterface;
use App\Shared\Infrastructure\DatabaseInterface;

class ModuleFunctionRepository implements ModuleFunctionRepositoryInterface
{
    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    public function save(ModuleFunction $moduleFunction): void
    {
        $sql = "INSERT INTO `module_function` (`id`, `name`, `module_id`) VALUES (:id, :name, :module_id)";

        $this->database->save($sql, [
            ':id' => $moduleFunction->getId(),
            ':name' => $moduleFunction->getName(),
            ':module_id' => $moduleFunction->getModule()->getId(),
        ]);
    }

    public function getByName(string $name): ?ModuleFunction
    {
        $sql = "SELECT `module_function`.* FROM `module_function` WHERE `name` = :name;";

        return $this->database->getObjectOne($sql, ModuleFunction::class, [':name' => $name]) ?: null;
    }
}
