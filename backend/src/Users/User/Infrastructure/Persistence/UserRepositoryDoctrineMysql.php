<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaTransformer;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserUuid;

final class UserRepositoryDoctrineMysql extends DoctrineRepository implements UserRepository
{
    private const FIELD_MAPPINGS = [
        'email' => 'email.value',
        'firstName' => 'firstName.value',
        'lastName' => 'lastName.value',
        'role' => 'role',
    ];

    private DoctrineCriteriaTransformer $transformer;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->transformer = new DoctrineCriteriaTransformer(self::FIELD_MAPPINGS);
    }

    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function find(UserUuid $uuid): ?User
    {
        return $this->repository(User::class)->find($uuid);
    }

    public function getByCriteria(Criteria $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder = $this->transformer->transform($criteria, $queryBuilder, 'u');
        $result = $queryBuilder->getQuery()->getResult();
        $total = $this->getTotalRows($queryBuilder);
        return ['items' => $result, 'total' => $total];
    }

    public function findByEmail(UserEmail $userEmail): ?User
    {
        return $this->repository(User::class)->findOneBy(['email.value' => $userEmail->value()]);
    }

    protected function entityClass(): string
    {
        return User::class;
    }

    private function getTotalRows(QueryBuilder $queryBuilder): int
    {
        $countQueryBuilder = clone $queryBuilder;
        $countQueryBuilder->select('COUNT(u.id)');

        return (int) $countQueryBuilder->getQuery()->getSingleScalarResult();
    }
}