<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Domain\ValueObject;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidUuid($value);
        $this->value = $value;
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }
    public function value(): string
    {
        return $this->value;
    }
    private function ensureIsValidUuid($id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }
    public function __toString()
    {
        return $this->value();
    }
}