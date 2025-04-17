<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\Exception\OutOfBoundsException;
use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class ProductName extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValid($value);
        parent::__construct($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('The product name cannot be empty.');
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\'-]+$/', $value)) {
            throw new InvalidArgumentException(sprintf('The product name "%s" contains invalid characters.', $value));
        }

        if (strlen($value) > 255) {
            throw new OutOfBoundsException('The product name length cannot exceed 255 characters.');
        }
    }
}