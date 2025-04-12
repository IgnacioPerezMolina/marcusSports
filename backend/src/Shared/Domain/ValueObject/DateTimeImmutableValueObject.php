<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\ValueObject;

use DateTimeImmutable;
use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;

class DateTimeImmutableValueObject
{
    protected DateTimeImmutable $value;
    public function __construct(DateTimeImmutable $value)
    {
        try {
            $this->value = $value;
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

    }
    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value()->format('Y-m-d H:i:s');
    }

    public static function create(): static
    {
        return new static((new DateTimeImmutable()));
    }
}