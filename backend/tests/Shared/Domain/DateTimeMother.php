<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Shared\Domain;

use DateTime;

class DateTimeMother
{
    public static function random(): DateTime
    {
        return MotherCreator::random()->dateTime();
    }

    public static function now(): DateTime
    {
        return MotherCreator::random()->dateTime('now');
    }
}