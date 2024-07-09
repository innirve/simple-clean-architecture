<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    #[\Override]
    public function save(User $user): User
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    #[\Override]
    public function findById(int $id): ?User
    {
        return $this->find($id);
    }

    #[\Override]
    public function delete(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    #[\Override]
    public function list(int $page, int $limit): array
    {
        $query = $this->createQueryBuilder('u')
            ->getQuery()
            ->setFirstResult(($page - 1) * $limit)->setMaxResults($limit)
        ;

        $paginator = new Paginator($query);

        return $paginator->getQuery()->getResult();
    }
}
