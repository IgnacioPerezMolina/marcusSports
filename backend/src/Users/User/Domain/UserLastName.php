<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\Exception\OutOfBoundsException;
use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class UserLastName extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValidLastName($value);
        parent::__construct($value);
    }

    private function ensureIsValidLastName(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('The last name cannot be empty.');
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\'-]+$/', $value)) {
            throw new InvalidArgumentException(sprintf('The last Name "%s" contains invalid characters.', $value));
        }

        if (strlen($value) > 255) {
            throw new OutOfBoundsException('The last name length cannot exceed 255 characters.');
        }
    }
}