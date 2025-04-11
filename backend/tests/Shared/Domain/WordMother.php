<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Shared\Domain;

class WordMother
{
    public static function random(): string
    {
        return MotherCreator::random()->word();
    }
}