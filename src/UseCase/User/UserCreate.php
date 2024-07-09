<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Api\Model\User\UserCreateModel;
use App\Api\View\User\UserItem;
use App\Entity\User;
use App\Utils\Password;

final class UserCreate extends UserUseCase
{
    public function execute(UserCreateModel $model): ?UserItem
    {
        return new UserItem(
            $this->repository->save(
                User::create(
                    $model->username,
                    Password::generatePlainPassword()
                )
            )
        );
    }
}
