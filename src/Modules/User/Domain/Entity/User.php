<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Entity;

class User
{

    private string $id;

    private string $name;

    private Group $group;

    public static function createUser(
        string $id,
        string $name,
        Group $group,
    ): self {
        $user = new self();
        $user->id = $id;
        $user->name = $name;
        $user->group = $group;

        return $user;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }
}
