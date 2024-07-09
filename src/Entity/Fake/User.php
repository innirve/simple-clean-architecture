<?php

declare(strict_types=1);

namespace App\Entity\Fake;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class User implements JWTUserInterface
{
    public function getId(): int
    {
        return 1;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string
    {
        return 'user_test';
    }

    public static function createFromPayload(mixed $username, array $payload): User
    {
        return new self();
    }
}
