<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Repository;

use App\Modules\User\Domain\Entity\Group;
use App\Shared\Infrastructure\DatabaseInterface;

class GroupRepository
{

    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    public function save(Group $group): void
    {
        $sql = "INSERT INTO `group` (id, name) VALUES (:id, :name);";

        $this->database->save($sql, [
            ':id' => $group->getId(),
            ':name' => $group->getName(),
        ]);
    }

    public function getByName(string $name): ?Group
    {
        $sql = "SELECT `group`.* FROM `group` WHERE name = :name;";

        return $this->database->getObjectOne($sql, Group::class, [':name' => $name]) ?: null;
    }
}
