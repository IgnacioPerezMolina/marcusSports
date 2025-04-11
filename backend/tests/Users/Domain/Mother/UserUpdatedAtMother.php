<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\Domain\Mother;

use DateTime;
use MarcusSports\Tests\Shared\Domain\DateTimeMother;
use MarcusSports\Users\Domain\UserUpdatedAt;

final class UserUpdatedAtMother
{
    public static function create(DateTime $value): UserUpdatedAt
    {
        return new UserUpdatedAt($value);
    }
    public static function random(): UserUpdatedAt
    {
        return self::create(DateTimeMother::random());
    }

    public static function now(): UserUpdatedAt
    {
        return self::create(DateTimeMother::now());
    }
}