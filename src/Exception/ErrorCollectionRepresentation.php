<?php

declare(strict_types=1);

namespace App\Exception;

use JMS\Serializer\Annotation as Serializer;

#[Serializer\ExclusionPolicy('all')]
final class ErrorCollectionRepresentation
{
    public function __construct(
        #[Serializer\Expose]
        public string $message,
        #[Serializer\Expose]
        public array $errors
    ) {}
}
