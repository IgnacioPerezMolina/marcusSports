<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain;

class PriceModifiersCollection
{
    /** @var PriceModifier[] */
    private array $priceModifiers;

    public function __construct(array $priceModifiers = [])
    {
        $this->priceModifiers = array_filter($priceModifiers, fn($item) => $item instanceof PriceModifier);
    }

    public function add(PriceModifier $priceModifier): void
    {
        $this->priceModifiers[] = $priceModifier;
    }

    /** @return PriceModifier[] */
    public function all(): array
    {
        return $this->priceModifiers;
    }

    public function toArray(): array
    {
        return array_map(fn(PriceModifier $priceModifier) => $priceModifier->toArray(), $this->priceModifiers);
    }
}