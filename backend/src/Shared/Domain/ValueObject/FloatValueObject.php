<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return number_format($this->value, 2, '.', '');
    }
}