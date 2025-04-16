<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Enum;

trait ValuableTrait
{
    public function value(): string
    {
        return $this->value;
    }
}