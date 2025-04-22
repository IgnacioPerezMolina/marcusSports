<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Persistence;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaTransformer;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\User;
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
        $transformer = new DoctrineCriteriaTransformer(self::FIELD_MAPPINGS);

        $queryBuilder = $this->entityManager()->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        $queryBuilder = $transformer->transform($criteria, $queryBuilder, 'u');
        $users = $queryBuilder->getQuery()->getResult();

        $countQueryBuilder = $this->entityManager()->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(User::class, 'u');

        $countCriteria = new Criteria(
            $criteria->filters(),
            $criteria->order(),
            null,
            null
        );

        $countQueryBuilder = $transformer->transform($countCriteria, $countQueryBuilder, 'u');
        $total = (int) $countQueryBuilder->getQuery()->getSingleScalarResult();

        return [
            'items' => $users,
            'total' => $total,
        ];
    }

    public function findByEmail(UserEmail $userEmail): ?User
    {
        return $this->repository(User::class)->findOneBy(['email.value' => $userEmail->value()]);
    }
}