<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Application\Mother;

use MarcusSports\Tests\Users\User\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUuidMother;
use MarcusSports\Users\User\Application\Create\CreateUserRequest;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserFirstName;
use MarcusSports\Users\User\Domain\UserLastName;
use MarcusSports\Users\User\Domain\UserPassword;
use MarcusSports\Users\User\Domain\UserUuid;

final class CreateUserRequestMother
{
    public static function create(
        UserUuid      $id,
        UserFirstName $firstName,
        UserLastName  $lastName,
        UserEmail     $email,
        UserPassword  $password
    ): CreateUserRequest
    {
        return new CreateUserRequest(
            $id->value(),
            $firstName->value(),
            $lastName->value(),
            $email->value(),
            $password->value()
        );
    }
    public static function random(): CreateUserRequest
    {
        return self::create(
            UserUuidMother::random(),
            UserFirstNameMother::random(),
            UserLastNameMother::random(),
            UserEmailMother::random(),
            UserPasswordMother::random()
        );
    }
}