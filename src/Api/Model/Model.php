<?php

declare(strict_types=1);

namespace App\Api\Model;

abstract class Model implements ModelInterface
{
    #[\Override]
    public function submittedData(): array
    {
        return get_object_vars($this);
    }

    public function key(string $field): mixed
    {
        return $this->{$field};
    }
}
