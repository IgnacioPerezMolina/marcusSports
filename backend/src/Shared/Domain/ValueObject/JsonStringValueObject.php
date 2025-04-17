<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Domain\ValueObject;

use InvalidArgumentException;
use JsonException;

abstract class JsonStringValueObject
{
    protected array $value;

    public function __construct(?string $value)
    {
        if ($value === null) {
            $this->value = [];
            return;
        }

        $decodedValue = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON string.');
        }
        $this->validate($decodedValue);
        $this->value = $decodedValue;
    }
    abstract protected function validate(array $value): void;

    public function toArray(): array
    {
        return $this->value;
    }

    public function __toString(): string
    {
        try {
            return json_encode($this->value, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Invalid JSON representation.');
        }
    }
}
