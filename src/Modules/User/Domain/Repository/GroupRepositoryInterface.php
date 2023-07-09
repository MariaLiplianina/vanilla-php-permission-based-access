<?php

namespace App\Modules\User\Domain\Repository;

use App\Modules\User\Domain\Entity\Group;

interface GroupRepositoryInterface
{
    public function save(Group $group): void;
    public function getByName(string $name): ?Group;
}
