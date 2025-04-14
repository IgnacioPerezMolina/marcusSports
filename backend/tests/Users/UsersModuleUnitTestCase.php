<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users;

use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UsersModuleUnitTestCase extends TestCase
{
    private $repository;
    protected function shouldSave(User $user): void
    {
        $this->repository()->method('save')->with($user);
    }

    /** @return UserRepository|MockObject */
    protected function repository(): MockObject
    {
        return $this->repository = $this->repository ?: $this->createMock(UserRepository::class);
    }

    protected function shouldFindByEmail(User $user, ?User $result): void
    {
        $this->repository()->expects($this->once())
            ->method('findByEmail')
            ->with($this->equalTo($user->email()))
            ->willReturn($result);
    }

}