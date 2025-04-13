<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Application\Mother;

use MarcusSports\Tests\Users\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\Domain\Mother\UserUuidMother;
use MarcusSports\Tests\Users\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\Domain\Mother\UserPasswordMother;
use MarcusSports\Users\Application\Create\CreateUserRequest;
use MarcusSports\Users\Domain\UserEmail;
use MarcusSports\Users\Domain\UserFirstName;
use MarcusSports\Users\Domain\UserUuid;
use MarcusSports\Users\Domain\UserLastName;
use MarcusSports\Users\Domain\UserPassword;

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