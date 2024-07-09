<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ControllerTest extends WebTestCase
{
    protected static string $jwt;

    public static function setUpBeforeClass(): void
    {
        self::$jwt = self::getJwt();
        static::ensureKernelShutdown();
    }

    public static function getJwt(?string $username = null): string
    {
        self::bootKernel();

        if (null === $username) {
            $username = 'user_test';
        }

        return static::$kernel
            ->getContainer()
            ->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $username])
        ;
    }

    public static function getAuthorizationHttpHeader(?string $username = null, ?string $contentType = null): array
    {
        return [
            'HTTP_Authorization' => 'Bearer '.self::getJwt($username),
            'Content-Type' => $contentType ?? 'application/json',
        ];
    }

    public static function getAppHost(): array|bool|string
    {
        return getenv('APP_HOST');
    }
}
