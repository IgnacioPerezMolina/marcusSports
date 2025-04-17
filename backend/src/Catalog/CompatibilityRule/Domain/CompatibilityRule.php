<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Domain;

use MarcusSports\Catalog\Product\Domain\Product;
use MarcusSports\Shared\Domain\Aggregate\Aggregate;

class CompatibilityRule extends Aggregate
{
    private CompatibilityRuleUuid $id;
    private Product $productId;
    private RuleExpression $ruleExpression;

    public function __construct(
        CompatibilityRuleUuid $id,
        Product $productId,
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

    public function productId(): Product
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

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'productId' => $this->productId->id()->value(),
            'ruleExpression' => $this->ruleExpression->toArray()
        ];
    }
}
