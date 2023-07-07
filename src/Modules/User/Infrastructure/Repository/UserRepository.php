<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Repository;

use App\Modules\User\Domain\Entity\User;
use App\Shared\Infrastructure\DatabaseInterface;

class UserRepository
{

    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    public function save(User $user): void
    {
        $sql = "INSERT INTO user (id, name, group_id) VALUES (:id, :name, :group_id)";

        $this->database->save($sql, [
            ':id' => $user->getId(),
            ':name' => $user->getName(),
            ':group_id' => $user->getGroup()->getId(),
        ]);
    }


    public function getByName(string $name): ?User
    {
        $sql = "SELECT `user`.* FROM `user` WHERE name = :name;";

        return $this->database->getObjectOne($sql, User::class, [':name' => $name]) ?: null;
    }
}
