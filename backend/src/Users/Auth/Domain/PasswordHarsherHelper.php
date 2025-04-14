<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Domain;

class PasswordHarsherHelper
{
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}