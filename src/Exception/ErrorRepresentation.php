<?php

declare(strict_types=1);

namespace App\Exception;

use JMS\Serializer\Annotation as Serializer;

final readonly class ErrorRepresentation
{
    public function __construct(#[Serializer\Expose, Serializer\Type('string')] public string $message) {}
}
