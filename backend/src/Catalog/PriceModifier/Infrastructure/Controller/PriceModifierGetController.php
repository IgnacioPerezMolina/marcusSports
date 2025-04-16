<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PriceModifier\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;

class PriceModifierGetController
{
    public function __construct()
    {
    }

    public function __invoke(): Response
    {
        return new Response('', Response::HTTP_CREATED);
    }
}