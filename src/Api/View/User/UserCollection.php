<?php

declare(strict_types=1);

namespace App\Api\View\User;

final readonly class UserCollection
{
    public int $page;
    public int $limit;
    public int $total;
    public array $data;

    public function __construct(int $page, int $limit, array $users)
    {
        $usersToReturn = [];

        foreach ($users as $user) {
            $usersToReturn[] = [
                'id' => $user->getId(),
                'username' => $user->getUserIdentifier(),
                'roles' => $user->getRoles(),
            ];
        }

        $this->page = $page;
        $this->limit = $limit;
        $this->total = count($usersToReturn);
        $this->data = $usersToReturn;
    }
}
