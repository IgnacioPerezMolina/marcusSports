<?php

declare(strict_types=1);

namespace MarcusSports\Users\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\Exception\OutOfBoundsException;
use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class UserFirstName extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidFirstName($value);
        parent::__construct($value);
    }

    private function ensureIsValidFirstName(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('The first name cannot be empty.');
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\'-]+$/', $value)) {
            throw new InvalidArgumentException(sprintf('The first Name "%s" contains invalid characters.', $value));
        }

        if (strlen($value) > 255) {
            throw new OutOfBoundsException('The first name length cannot exceed 255 characters.');
        }
    }
}