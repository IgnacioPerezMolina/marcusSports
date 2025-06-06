<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\User\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\UuidMother;
use MarcusSports\Users\User\Domain\UserUuid;

final class UserUuidMother
{
    public static function create(string $value): UserUuid
    {
        return new UserUuid($value);
    }
    public static function random(): UserUuid
    {
        return self::create(UuidMother::random());
    }
}