<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\WordMother;
use MarcusSports\Users\User\Domain\UserFirstName;

final class UserFirstNameMother
{
    public static function create(string $value): UserFirstName
    {
        return new UserFirstName($value);
    }
    public static function random(): UserFirstName
    {
        return self::create(WordMother::random());
    }
}