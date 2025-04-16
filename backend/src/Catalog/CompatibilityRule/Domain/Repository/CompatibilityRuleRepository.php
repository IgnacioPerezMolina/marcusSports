<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Domain\Repository;

use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRule;

interface CompatibilityRuleRepository
{
    public function save(CompatibilityRule $compatibilityRule): void;
}