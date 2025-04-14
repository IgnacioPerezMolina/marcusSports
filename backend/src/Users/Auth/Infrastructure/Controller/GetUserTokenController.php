<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;

class GetUserTokenController
{
    public function __invoke(): Response
    {
        return new Response('', Response::HTTP_CREATED);
    }
}