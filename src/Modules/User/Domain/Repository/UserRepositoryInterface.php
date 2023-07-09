<?php

namespace App\Modules\User\Domain\Repository;

use App\Modules\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function getByName(string $name): ?User;
}
