<?php

declare(strict_types=1);

namespace MarcusSports\Users\Infrastructure\Persistence;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MarcusSports\Shared\Infrastructure\Repository\OperatorMapper;
use MarcusSports\Users\Domain\Repository\UserRepository;
use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\UserCollection;
use MarcusSports\Users\Domain\UserEmail;
use MarcusSports\Users\Domain\UserUuid;

class UserRepositoryDoctrineMysql extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function find(UserUuid $uuid): ?User
    {
        return $this->repository(User::class)->find($uuid);
    }

    public function getByCriteria(Criteria $criteria): PaginatedResult
    {
        $query = $this->entityManager()->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        if ($criteria->hasFilters()) {
            foreach ($criteria->filters()->filters() as $key => $filter) {
                $fieldName = $filter->field();
                $field = match ($fieldName) {
                    'email.value' => 'LOWER(u.email.value)',
                    'first_name.value' => 'LOWER(u.first_name.value)',
                    default => 'u.' . $fieldName
                };

                $paramName = 'param_' . $key;

                if ($filter->operator()->value() === FilterOperator::CONTAINS->value) {
                    $paramValue = '%' . strtolower($filter->value()) . '%';
                } else {
                    $paramValue = $filter->value();
                }

                $query->andWhere(
                    sprintf('%s %s :%s',
                        $field,
                        OperatorMapper::mapOperator($filter->operator()->value()),
                        $paramName
                    )
                )->setParameter($paramName, $paramValue);
            }
        }

        $countQuery = clone $query;
        $total = $countQuery->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        if ($order = $criteria->order()) {
            $query->orderBy(
                'u.' . $order->orderBy(),
                $order->orderType()->value
            );
        }

        if ($criteria->offset()) {
            $query->setFirstResult($criteria->offset());
        }

        if ($criteria->limit()) {
            $query->setMaxResults($criteria->limit());
        }

        return
            new PaginatedResult(
                items: new UserCollection($query->getQuery()->getResult()),
                total: $total,
                currentPage: $criteria->currentPage(),
                itemsPerPage: $criteria->limit()
            );
    }

    public function findByEmail(UserEmail $userEmail): ?User
    {
        return $this->repository(User::class)->findOneBy(['email.value' => $userEmail->value()]);
    }
}