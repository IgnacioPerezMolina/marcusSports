<?php

declare(strict_types=1);

namespace MarcusSports\Users\Infrastructure\Persistence;

use MarcusSports\Shared\Infrastructure\Persistence\DoctrineRepository;
use MarcusSports\Users\Domain\Repository\UserRepository;
use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\UserId;

class UserRepositoryDoctrineMysql extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function find(UserId $id): ?User
    {
        return $this->repository(User::class)->find($id);
    }

//    public function search(string $id): User
//    {
//
//    }
}