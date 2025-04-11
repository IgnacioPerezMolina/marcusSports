<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\WordMother;
use MarcusSports\Users\Domain\UserLastName;

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