<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\CompatibilityRule\Application\Get;

use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRuleCollection;
use MarcusSports\Catalog\CompatibilityRule\Domain\Repository\CompatibilityRuleRepository;

class CompatibilityRuleGetter
{
    public function __invoke(GetCompatibilityRuleRequest $request, CompatibilityRuleRepository $repository): array
    {
        $compatibilityRules = $repository->findAll();
        return (new CompatibilityRuleCollection($compatibilityRules))->toArray();
    }
}