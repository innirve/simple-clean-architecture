<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Api\View\User\UserItem;
use App\Exception\User\UserNotFoundException;

final class UserRead extends UserUseCase
{
    public function execute(int $userId): ?UserItem
    {
        if (!$user = $this->repository->findById($userId)) {
            throw new UserNotFoundException();
        }

        return new UserItem($user);
    }
}
