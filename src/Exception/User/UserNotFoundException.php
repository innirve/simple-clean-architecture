<?php

declare(strict_types=1);

namespace App\Exception\User;

use App\Exception\ApiException;

final class UserNotFoundException extends ApiException
{
    public function __construct()
    {
        $this->code = self::NOT_FOUND;

        parent::__construct();
    }

    #[\Override]
    protected function errorMessage(): string
    {
        return 'user.entity.not_found';
    }
}
