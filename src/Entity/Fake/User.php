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

    #[\Override]
    public function getRoles(): array
    {
        return [];
    }

    #[\Override]
    public function eraseCredentials(): void {}

    #[\Override]
    public function getUserIdentifier(): string
    {
        return 'user_test';
    }

    #[\Override]
    public static function createFromPayload(mixed $username, array $payload): User
    {
        return new self();
    }
}
