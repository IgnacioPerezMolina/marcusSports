<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain\Mother;

use MarcusSports\Users\User\Application\Create\CreateUserRequest;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserCreatedAt;
use MarcusSports\Users\User\Domain\UserDeletedAt;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserFirstName;
use MarcusSports\Users\User\Domain\UserLastName;
use MarcusSports\Users\User\Domain\UserPassword;
use MarcusSports\Users\User\Domain\UserRole;
use MarcusSports\Users\User\Domain\UserUpdatedAt;
use MarcusSports\Users\User\Domain\UserUuid;

final class UserMother
{
    public static function create(
        UserUuid       $id,
        UserFirstName  $firstName,
        UserLastName   $lastName,
        UserEmail      $email,
        UserRole       $role,
        UserPassword   $password,
        UserCreatedAt  $createdAt,
        UserUpdatedAt  $updatedAt,
        ?UserDeletedAt $deletedAt
    ): User {
        return new User($id, $firstName, $lastName, $email, $role, $password, $createdAt, $updatedAt, $deletedAt);
    }

    public static function fromRequest(CreateUserRequest $request): User
    {
        return self::create(
            UserUuidMother::create($request->id()),
            UserFirstNameMother::create($request->firstName()),
            UserLastNameMother::create($request->lastName()),
            UserEmailMother::create($request->email()),
            UserRole::USER,
            UserPasswordMother::fromPlain($request->password()),
            UserCreatedAtMother::now(),
            UserUpdatedAtMother::now(),
            null
        );
    }

    public static function random(): User {
        return self::create(
            UserUuidMother::random(),
            UserFirstNameMother::random(),
            UserLastNameMother::random(),
            UserEmailMother::random(),
            UserRole::USER,
            UserPasswordMother::random(),
            UserCreatedAtMother::now(),
            UserUpdatedAtMother::now(),
            null
        );
    }

    public static function deletedUser(): User {
        return self::create(
            UserUuidMother::random(),
            UserFirstNameMother::random(),
            UserLastNameMother::random(),
            UserEmailMother::random(),
            UserRole::USER,
            UserPasswordMother::random(),
            UserCreatedAtMother::now(),
            UserUpdatedAtMother::now(),
            UserDeletedAtMother::now()
        );
    }
}