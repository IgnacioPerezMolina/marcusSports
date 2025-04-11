<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\PasswordMother;
use MarcusSports\Users\Domain\UserPassword;

final class UserPasswordMother
{
    public static function create(string $value): UserPassword
    {
        return new UserPassword($value);
    }
    public static function random(): UserPassword
    {
        return self::create(PasswordMother::random());
    }
}