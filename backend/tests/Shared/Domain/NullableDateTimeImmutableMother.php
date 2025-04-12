<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Shared\Domain;

use DateTimeImmutable;

class NullableDateTimeImmutableMother
{
    public static function random(): DateTimeImmutable
    {
//        return MotherCreator::random()->dateTime();
        return new DateTimeImmutable();
    }

    public static function now(): DateTimeImmutable
    {
//        return MotherCreator::random()->dateTime('now');
        return new DateTimeImmutable();
    }
}