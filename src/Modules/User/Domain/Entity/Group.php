<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Entity;

class Group
{

	private string $id;

	private string $name;

    public static function createGroup(
        string $id,
        string $name,
    ): self {
        $group = new self();
        $group->id = $id;
        $group->name = $name;

        return $group;
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
