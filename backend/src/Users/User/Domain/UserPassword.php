<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Domain;

use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class UserPassword extends StringValueObject
{
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
}