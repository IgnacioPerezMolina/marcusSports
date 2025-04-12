<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\ValueObject;

use DateTime;
use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;

class DateTimeValueObject
{
    protected DateTime $value;
    public function __construct(DateTime $value)
    {
        try {
            $this->value = clone $value;
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

    }
    public function value(): DateTime
    {
        return clone $this->value;
    }

    public function __toString(): string
    {
        return $this->value()->format('Y-m-d H:i:s');
    }

    public static function create(): static
    {
        return new static((new DateTime()));
    }
}