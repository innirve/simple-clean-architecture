<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function list(int $page, int $limit): array;

    public function save(User $user): User;

    public function findById(int $id): ?User;

    public function delete(User $user): void;
}
