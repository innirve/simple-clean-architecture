<?php

declare(strict_types=1);

namespace App\Api\View\User;

use App\Entity\User;

final readonly class UserItem
{
    public ?int $id;
    public ?string $username;
    public ?array $roles;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->username = $user->getUserIdentifier();
        $this->roles = $user->getRoles();
    }
}
