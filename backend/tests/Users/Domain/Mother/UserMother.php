<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain\Mother;

use MarcusSports\Users\Application\Create\CreateUserRequest;
use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\UserCreatedAt;
use MarcusSports\Users\Domain\UserDeletedAt;
use MarcusSports\Users\Domain\UserEmail;
use MarcusSports\Users\Domain\UserFirstName;
use MarcusSports\Users\Domain\UserId;
use MarcusSports\Users\Domain\UserLastName;
use MarcusSports\Users\Domain\UserPassword;
use MarcusSports\Users\Domain\UserUpdatedAt;

final class UserMother
{
    public static function create(
        UserId $id,
        UserFirstName $firstName,
        UserLastName $lastName,
        UserEmail $email,
        UserPassword $password,
        UserCreatedAt $createdAt,
        UserUpdatedAt $updatedAt,
        ?UserDeletedAt $deletedAt
    ): User {
        return new User($id, $firstName, $lastName, $email, $password, $createdAt, $updatedAt, $deletedAt);
    }

    public static function fromRequest(CreateUserRequest $request): User
    {
        return self::create(
            UserIdMother::create($request->id()),
            UserFirstNameMother::create($request->firstName()),
            UserLastNameMother::create($request->lastName()),
            UserEmailMother::create($request->email()),
            UserPasswordMother::create($request->password()),
            UserCreatedAtMother::now(),
            UserUpdatedAtMother::now(),
            null
        );
    }

    public static function random(): User {
        return self::create(
            UserIdMother::random(),
            UserFirstNameMother::random(),
            UserLastNameMother::random(),
            UserEmailMother::random(),
            UserPasswordMother::random(),
            UserCreatedAtMother::now(),
            UserUpdatedAtMother::now(),
            null
        );
    }

    public static function deletedUser(): User {
        return self::create(
            UserIdMother::random(),
            UserFirstNameMother::random(),
            UserLastNameMother::random(),
            UserEmailMother::random(),
            UserPasswordMother::random(),
            UserCreatedAtMother::now(),
            UserUpdatedAtMother::now(),
            UserDeletedAtMother::now()
        );
    }
}