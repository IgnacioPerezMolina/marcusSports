<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Domain;

use MarcusSports\Shared\Domain\ValueObject\Uuid;

final class CompatibilityRuleUuid extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}