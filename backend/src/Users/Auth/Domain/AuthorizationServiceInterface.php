<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Domain;

interface AuthorizationServiceInterface
{
    public function isAllowed(string $userId, string $resource, string $action): bool;
}