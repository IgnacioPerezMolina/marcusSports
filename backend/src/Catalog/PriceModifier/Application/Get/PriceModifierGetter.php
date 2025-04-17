<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PriceModifier\Application\Get;

use MarcusSports\Catalog\PriceModifier\Domain\PriceModifiersCollection;
use MarcusSports\Catalog\PriceModifier\Domain\Repository\PriceModifierRepository;

class PriceModifierGetter
{
    public function __invoke(GetPriceModifierRequest $request, PriceModifierRepository $repository)
    {
        $priceModifiers = $repository->findAll();
        return (new PriceModifiersCollection($priceModifiers))->toArray();
    }
}