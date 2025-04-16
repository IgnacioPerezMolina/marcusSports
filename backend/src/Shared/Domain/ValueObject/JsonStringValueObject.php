<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Domain\ValueObject;

use InvalidArgumentException;
use JsonException;

abstract class JsonStringValueObject
{
    protected array $value;

    public function __construct(string $json)
    {
        try {
            $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Invalid JSON provided: ' . $e->getMessage());
        }

        $this->value = $decoded;
        $this->validate($this->value);
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
