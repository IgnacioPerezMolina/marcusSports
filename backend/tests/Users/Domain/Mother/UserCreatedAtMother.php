<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\Domain\Mother;

use DateTime;
use MarcusSports\Tests\Shared\Domain\DateTimeMother;
use MarcusSports\Users\Domain\UserCreatedAt;

final class UserCreatedAtMother
{
    public static function create(DateTime $value): UserCreatedAt
    {
        return new UserCreatedAt($value);
    }
    public static function random(): UserCreatedAt
    {
        return self::create(DateTimeMother::random());
    }

    public static function now(): UserCreatedAt
    {
        return self::create(DateTimeMother::now());
    }
}