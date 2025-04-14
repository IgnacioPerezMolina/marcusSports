<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain\Mother;

use DateTimeImmutable;
use MarcusSports\Tests\Shared\Domain\DateTimeImmutableMother;
use MarcusSports\Users\User\Domain\UserDeletedAt;

final class UserDeletedAtMother
{
    public static function create(?DateTimeImmutable $value): UserDeletedAt
    {
        return new UserDeletedAt($value);
    }
    public static function random(): UserDeletedAt
    {
        return self::create(DateTimeImmutableMother::random());
    }

    public static function now(): UserDeletedAt
    {
        return self::create(DateTimeImmutableMother::now());
    }
}