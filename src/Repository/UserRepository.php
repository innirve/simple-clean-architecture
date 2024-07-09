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

    public function save(User $user): User
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    public function findById(int $id): ?User
    {
        return $this->find($id);
    }

    public function delete(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

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
