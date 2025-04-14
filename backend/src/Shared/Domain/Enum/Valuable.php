<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Enum;

interface Valuable
{
    public function value(): string;
}