<?php

declare(strict_types=1);


namespace MarcusSports\Users\User\Infrastructure\Persistence;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserUuid;

class UserRepositoryElasticSearch implements UserRepository
{

    public function save(User $user): void
    {
        // TODO: Implement save() method.
    }

    public function find(UserUuid $uuid): ?User
    {
        return null;
    }

    public function findByEmail(UserEmail $userEmail): ?User
    {
        return null;
    }

    public function getByCriteria(Criteria $criteria): array
    {
        return [];
    }
}