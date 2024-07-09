<?php

declare(strict_types=1);

namespace App\Exception;

abstract class ApiException extends \DomainException
{
    public const int NOT_FOUND = 404;
    public const int INVALID = 400;

    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract protected function errorMessage(): string;
}
