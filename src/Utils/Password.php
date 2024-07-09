<?php

declare(strict_types=1);

namespace App\Utils;

final class Password
{
    public static function generatePlainPassword(): string
    {
        return bin2hex(random_bytes(4)).'a0-';
    }
}
