<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use DateTime;
use MarcusSports\Tests\Users\Domain\Mother\UserCreatedAtMother;
use MarcusSports\Tests\Users\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\Domain\Mother\UserUuidMother;
use MarcusSports\Tests\Users\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\Domain\Mother\UserMother;
use MarcusSports\Tests\Users\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\Domain\Mother\UserUpdatedAtMother;
use MarcusSports\Users\Domain\User;
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
        $password = UserPasswordMother::create('hashed-password');
        $createdAt = UserCreatedAtMother::create(new DateTime('2023-04-12 14:00:00'));
        $updatedAt = UserUpdatedAtMother::create(new DateTime('2023-04-12 14:00:00'));
        $deletedAt = null;

        $user = new User($id, $firstName, $lastName, $email, $password, $createdAt, $updatedAt, $deletedAt);

        $this->assertSame('123e4567-e89b-12d3-a456-426614174000', $user->id()->value());
        $this->assertSame('Ignacio', $user->firstName()->value());
        $this->assertSame('Garcia', $user->lastName()->value());
        $this->assertSame('email@example.com', $user->email()->value());
        $this->assertSame('hashed-password', $user->password()->value());
        $this->assertSame('2023-04-12 14:00:00', $user->createdAt()->__toString());
        $this->assertSame('2023-04-12 14:00:00', $user->updatedAt()->__toString());
        $this->assertNull($user->deletedAt());
    }
}