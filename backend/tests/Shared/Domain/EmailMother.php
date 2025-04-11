<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Shared\Domain;

class EmailMother
{
    public static function random(): string
    {
        return MotherCreator::random()->email();
    }
}