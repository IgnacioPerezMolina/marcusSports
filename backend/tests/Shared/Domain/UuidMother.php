<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Shared\Domain;

use MarcusSports\Shared\Domain\ValueObject\Uuid;

class UuidMother
{
    public static function random(): string
    {
        return Uuid::random()->value();
    }
}