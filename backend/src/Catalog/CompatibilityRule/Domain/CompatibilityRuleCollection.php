<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Domain;

final class CompatibilityRuleCollection
{
    private array $compatibilityRules;

    public function __construct(array $compatibilityRules = [])
    {
        $this->compatibilityRules = array_filter($compatibilityRules, fn($item) => $item instanceof CompatibilityRule);
    }

    public function add(CompatibilityRule $compatibilityRule): void
    {
        $this->compatibilityRules[] = $compatibilityRule;
    }

    public function all(): array
    {
        return $this->compatibilityRules;
    }

    public function toArray(): array
    {
        return array_map(fn(CompatibilityRule $compatibilityRule) => $compatibilityRule->toArray(), $this->compatibilityRules);
    }
}