<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\User\Domain\Mother;

use MarcusSports\Tests\Shared\Domain\EmailMother;
use MarcusSports\Users\User\Domain\UserEmail;

final class UserEmailMother
{
    public static function create(string $value): UserEmail
    {
        return new UserEmail($value);
    }
    public static function random(): UserEmail
    {
        return self::create(EmailMother::random());
    }
}