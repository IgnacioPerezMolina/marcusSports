<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PriceModifier\Infrastructure\Controller;

use MarcusSports\Catalog\PriceModifier\Application\Get\GetPriceModifierRequest;
use MarcusSports\Catalog\PriceModifier\Application\Get\PriceModifierGetter;
use MarcusSports\Catalog\PriceModifier\Domain\Repository\PriceModifierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PriceModifierGetController
{
    public function __construct(
        private PriceModifierGetter $priceModifierGetter,
        private PriceModifierRepository $repository
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $priceModifiers = $this->priceModifierGetter->__invoke(new GetPriceModifierRequest($request), $this->repository);

        return new Response(
            json_encode($priceModifiers),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}