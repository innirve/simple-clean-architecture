<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Api\View\User\UserCollection;

final class UserList extends UserUseCase
{
    public function execute(int $page, int $limit): UserCollection
    {
        return new UserCollection($page, $limit, $this->repository->list($page, $limit));
    }
}
