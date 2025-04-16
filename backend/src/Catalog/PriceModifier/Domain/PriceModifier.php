<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain;

use MarcusSports\Catalog\Product\Domain\Product;

class PriceModifier
{
    private PriceModifierUuid $id;
    private Product $productId;
    private PriceModifierCondition $condition;
    private PriceModifierAdjustment $adjustment;
    private PriceModifierScope $scope;

    public function __construct(
        PriceModifierUuid $id,
        Product $productId,
        PriceModifierCondition $condition,
        PriceModifierAdjustment $adjustment,
        PriceModifierScope $scope
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->condition = $condition;
        $this->adjustment = $adjustment;
        $this->scope = $scope;
    }

    public function id(): PriceModifierUuid
    {
        return $this->id;
    }

    public function productId(): Product
    {
        return $this->productId;
    }

    public function condition(): PriceModifierCondition
    {
        return $this->condition;
    }

    public function adjustment(): PriceModifierAdjustment
    {
        return $this->adjustment;
    }

    public function scope(): PriceModifierScope
    {
        return $this->scope;
    }
}
