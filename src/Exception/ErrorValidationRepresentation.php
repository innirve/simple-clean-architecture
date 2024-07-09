<?php

declare(strict_types=1);

namespace App\Exception;

use JMS\Serializer\Annotation as Serializer;

#[Serializer\ExclusionPolicy('all')]
final readonly class ErrorValidationRepresentation
{
    public function __construct(
        #[Serializer\Expose]
        public string $message,
        #[Serializer\Expose]
        public ?string $field = null
    ) {}
}
