<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

final class HealthCheckGetController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'ok'
            ]
        );
    }
}