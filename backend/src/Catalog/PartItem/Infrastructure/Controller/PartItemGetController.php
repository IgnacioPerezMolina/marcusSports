<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartItem\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;

class PartItemGetController
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        return new Response('', Response::HTTP_CREATED);
    }
}