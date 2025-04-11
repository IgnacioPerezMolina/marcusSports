<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\UuidMother;
use MarcusSports\Users\Domain\UserId;

final class UserIdMother
{
    public static function create(string $value): UserId
    {
        return new UserId($value);
    }
    public static function random(): UserId
    {
        return self::create(UuidMother::random());
    }
}