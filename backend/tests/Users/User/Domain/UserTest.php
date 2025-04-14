<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain;

use DateTime;
use MarcusSports\Tests\Users\User\Domain\Mother\UserCreatedAtMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserRoleMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUpdatedAtMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUuidMother;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserRole;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_user_should_be_created()
    {
        $user = UserMother::random();

        $this->assertInstanceOf(User::class, $user);
    }

    public function test_user_should_be_created_and_getters_return_expected_values(): void
    {
        $id = UserUuidMother::create('123e4567-e89b-12d3-a456-426614174000');
        $firstName = UserFirstNameMother::create('Ignacio');
        $lastName = UserLastNameMother::create('Garcia');
        $email = UserEmailMother::create('email@example.com');
        $role = UserRoleMother::user();
        $password = UserPasswordMother::fromPlain('hashed-password');
        $createdAt = UserCreatedAtMother::create(new DateTime('2023-04-12 14:00:00'));
        $updatedAt = UserUpdatedAtMother::create(new DateTime('2023-04-12 14:00:00'));
        $deletedAt = null;

        $user = new User($id, $firstName, $lastName, $email, $role, $password, $createdAt, $updatedAt, $deletedAt);

        $this->assertSame('123e4567-e89b-12d3-a456-426614174000', $user->id()->value());
        $this->assertSame('Ignacio', $user->firstName()->value());
        $this->assertSame('Garcia', $user->lastName()->value());
        $this->assertSame('email@example.com', $user->email()->value());
        $this->assertSame(UserRole::USER, $user->role());
        $this->assertTrue($user->password()->verify('hashed-password'));
        $this->assertSame('2023-04-12 14:00:00', $user->createdAt()->__toString());
        $this->assertSame('2023-04-12 14:00:00', $user->updatedAt()->__toString());
        $this->assertNull($user->deletedAt());
    }
}