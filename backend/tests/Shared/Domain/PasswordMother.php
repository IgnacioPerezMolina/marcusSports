<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Shared\Domain;

class PasswordMother
{
    public static function random(): string
    {
        return MotherCreator::random()->password(8);
    }
}