<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\Exception\OutOfBoundsException;
use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class PartItemLabel extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsValid($value);
        parent::__construct($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('The label cannot be empty.');
        }

        if (!preg_match('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\'-]+$/', $value)) {
            throw new InvalidArgumentException(sprintf('The label "%s" contains invalid characters.', $value));
        }

        if (strlen($value) > 255) {
            throw new OutOfBoundsException('The label length cannot exceed 255 characters.');
        }
    }
}