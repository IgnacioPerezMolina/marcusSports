<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Domain;

use MarcusSports\Shared\Domain\Collection;

final class CompatibilityRuleCollection extends Collection
{

    // TODO review this

//    protected ?string $type = CompatibilityRule::class;
//
//    public function __construct(array $elements = [])
//    {
//        parent::__construct($elements, $this->type);
//    }

    private array $compatibilityRules;

    public function __construct(array $compatibilityRules = [])
    {
        $this->compatibilityRules = array_filter($compatibilityRules, fn($item) => $item instanceof CompatibilityRule);
    }

    public function add(CompatibilityRule $compatibilityRule): void
    {
        $this->compatibilityRules[] = $compatibilityRule;
    }

    /** @return CompatibilityRule[] */
    public function all(): array
    {
        return $this->compatibilityRules;
    }

    public function toArray(): array
    {
        return array_map(fn(CompatibilityRule $compatibilityRule) => $compatibilityRule->toArray(), $this->compatibilityRules);
    }
}