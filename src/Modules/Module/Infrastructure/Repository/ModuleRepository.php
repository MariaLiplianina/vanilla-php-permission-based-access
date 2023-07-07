<?php

declare(strict_types=1);

namespace App\Modules\Module\Infrastructure\Repository;

use App\Modules\Module\Domain\Entity\Module;
use App\Shared\Infrastructure\DatabaseInterface;

class ModuleRepository
{

    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    public function save(Module $module): void
    {
        $sql = "INSERT INTO module (id, name) VALUES (:id, :name)";

        $this->database->save($sql, [
            ':id' => $module->getId(),
            ':name' => $module->getName(),
        ]);
    }

    public function getByName(string $name): ?Module
    {
        $sql = "SELECT `module`.* FROM `module` WHERE `name` = :name;";

        return $this->database->getObjectOne($sql, Module::class, [':name' => $name]) ?: null;
    }
}
