<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\User\Domain\Mother;

use MarcusSports\Users\User\Domain\UserRole;

final class UserRoleMother
{
    public static function random(): UserRole
    {
        $cases = UserRole::cases();
        return $cases[array_rand($cases)];
    }

    public static function user(): UserRole
    {
        return UserRole::USER;
    }

    public static function employee(): UserRole
    {
        return UserRole::EMPLOYEE;
    }

    public static function admin(): UserRole
    {
        return UserRole::ADMIN;
    }
}