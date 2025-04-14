<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Domain;

use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class UserPassword extends StringValueObject
{
    const MIN_LENGTH = 8;
    const MAX_LENGTH = 255;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public static function fromPlain(string $plainPassword): self
    {
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
        return new self($hashedPassword);
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->value());
    }

    private function validate(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('El password debe tener al menos %d caracteres.', self::MIN_LENGTH)
            );
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('El password no puede tener más de %d caracteres.', self::MAX_LENGTH)
            );
        }

        if (!preg_match('/[A-Za-z]/', $value) || !preg_match('/[0-9]/', $value)) {
            throw new \InvalidArgumentException(
                'El password debe contener al menos una letra y un número.'
            );
        }
    }
}