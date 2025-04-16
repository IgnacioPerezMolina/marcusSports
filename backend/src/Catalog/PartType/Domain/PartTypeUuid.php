<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Domain;

use MarcusSports\Shared\Domain\ValueObject\Uuid;

final class PartTypeUuid extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}