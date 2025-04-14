<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\PasswordMother;
use MarcusSports\Users\User\Domain\UserPassword;

final class UserPasswordMother
{
    public static function create(string $value): UserPassword
    {
        return self::fromPlain($value);
    }
    public static function random(): UserPassword
    {
        $plainPassword = PasswordMother::random();
        return self::fromPlain($plainPassword);
    }

    public static function fromPlain(string $plainPassword): UserPassword
    {
        return UserPassword::fromPlain($plainPassword);
    }
}