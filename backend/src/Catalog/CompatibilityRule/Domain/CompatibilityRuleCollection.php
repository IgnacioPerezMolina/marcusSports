<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Domain;

use MarcusSports\Shared\Domain\Collection;

final class CompatibilityRuleCollection extends Collection
{
    protected string $type = CompatibilityRule::class;

    public function __construct(array $elements = [])
    {
        parent::__construct($elements, $this->type);
    }
}
