<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Domain;

use MarcusSports\Shared\Domain\ValueObject\BooleanValueObject;

final class PartTypeRequired extends BooleanValueObject
{
    public function __construct(bool $value)
    {
        parent::__construct($value);
    }
}