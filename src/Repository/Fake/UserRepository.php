<?php

declare(strict_types=1);

namespace App\Repository\Fake;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

final class UserRepository implements UserRepositoryInterface
{
    private ArrayCollection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();

        $user1 = (new User())->setId(1)->setIdentifier('identifier1');
        $user2 = (new User())->setId(2)->setIdentifier('identifier2');
        $user3 = (new User())->setId(3)->setIdentifier('identifier3');

        $this->users->add($user1);
        $this->users->add($user2);
        $this->users->add($user3);
    }

    #[\Override]
    public function list(int $page, int $limit): array
    {
        return $this->users->getValues();
    }

    #[\Override]
    public function save(User $user): User
    {
        if (!$this->users->contains($user)) {
            $user->setId($this->getIdAutoIncrements());
        } else {
            foreach ($this->users as $userMemory) {
                if ($user->getId() === $userMemory->getId()) {
                    $this->users->removeElement($userMemory);
                }
            }
        }

        $this->users->add($user);

        return $user;
    }

    #[\Override]
    public function findById(int $id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }

        return null;
    }

    #[\Override]
    public function delete(User $user): void
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }
    }

    private function getIdAutoIncrements(): int
    {
        $ids = [];

        foreach ($this->users as $user) {
            $ids[] = $user->getId();
        }

        sort($ids);

        return end($ids) + 1;
    }
}
