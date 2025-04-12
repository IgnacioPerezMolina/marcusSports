<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Domain\ValueObject;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;

abstract class EmailValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidEmail($value);
        $this->value = $value;
    }

    private function ensureIsValidEmail(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('The email "%s" is not valid.', $value));
        }


        $parts = explode('@', $value);
        $domain = $parts[1] ?? '';

        if (substr_count($domain, '.') < 1) {
            throw new InvalidArgumentException(sprintf('The email "%s" has not valid domain.', $value));
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
