<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\WordMother;
use MarcusSports\Users\User\Domain\UserLastName;

final class UserLastNameMother
{
    public static function create(string $value): UserLastName
    {
        return new UserLastName($value);
    }
    public static function random(): UserLastName
    {
        return self::create(WordMother::random());
    }
}