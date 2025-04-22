<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Persistence;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaTransformer;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MarcusSports\Shared\Infrastructure\Repository\OperatorMapper;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserCollection;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserUuid;

class UserRepositoryDoctrineMysql extends DoctrineRepository implements UserRepository
{
    private const FIELD_MAPPINGS = [
        'email' => 'email.value',
        'firstName' => 'firstName.value',
        'lastName' => 'lastName.value',
        'role' => 'role',
    ];

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
        $queryBuilder = $this->entityManager()->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        $transformer = new DoctrineCriteriaTransformer(self::FIELD_MAPPINGS);
        $queryBuilder = $transformer->transform($queryBuilder, $criteria, 'u');

        return $queryBuilder->getQuery()->getResult();
    }

    public function findByEmail(UserEmail $userEmail): ?User
    {
        return $this->repository(User::class)->findOneBy(['email.value' => $userEmail->value()]);
    }
}