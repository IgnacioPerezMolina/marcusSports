<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users;

use MarcusSports\Users\Domain\Repository\UserRepository;
use MarcusSports\Users\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserModuleUnitTestCase extends TestCase
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
}