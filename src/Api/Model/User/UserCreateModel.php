<?php

declare(strict_types=1);

namespace App\Api\Model\User;

use App\Api\Model\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Creates an User',
    description: 'Procedure to create an user with its fields in the database.',
    required: ['username']
)]
final class UserCreateModel extends Model
{
    #[OA\Property(description: 'The user\'s username', type: 'string', example: 'username_1')]
    public ?string $username;

    public function __invoke(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $this->username = $data['username'];

        return $this;
    }
}
