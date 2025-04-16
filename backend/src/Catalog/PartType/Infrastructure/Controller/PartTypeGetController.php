<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;

class PartTypeGetController
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        return new Response('', Response::HTTP_CREATED);
    }
}