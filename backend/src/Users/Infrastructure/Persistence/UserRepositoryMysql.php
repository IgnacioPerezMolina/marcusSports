<?php

declare(strict_types=1);

namespace MarcusSports\Users\Infrastructure\Persistence;

use MarcusSports\Shared\Infrastructure\Persistence\DoctrineRepository;
use MarcusSports\Users\Domain\Repository\UserRepository;
use MarcusSports\Users\Domain\User;

class UserRepositoryMysql extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }
}