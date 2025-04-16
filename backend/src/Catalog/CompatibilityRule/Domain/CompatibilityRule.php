<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Domain;

use MarcusSports\Catalog\Product\Domain\ProductUuid;

class CompatibilityRule
{
    private CompatibilityRuleUuid $id;
    private ProductUuid $productId;
    private RuleExpression $ruleExpression;

    public function __construct(
        CompatibilityRuleUuid $id,
        ProductUuid $productId,
        RuleExpression $ruleExpression
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->ruleExpression = $ruleExpression;
    }
    public function id(): CompatibilityRuleUuid
    {
        return $this->id;
    }

    public function productId(): ProductUuid
    {
        return $this->productId;
    }

    public function ruleExpression(): RuleExpression
    {
        return $this->ruleExpression;
    }

    // TODO Ejemplo de comportamiento: evaluar la regla contra una configuración
    // public function isSatisfiedBy(ProductConfiguration $configuration): bool {
    //     // $this->ruleExpression.
    // }
}
