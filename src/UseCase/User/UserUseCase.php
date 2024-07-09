<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Repository\UserRepositoryInterface;

abstract class UserUseCase
{
    public function __construct(
        protected readonly UserRepositoryInterface $repository
    ) {}
}
