<?php

declare(strict_types=1);

namespace MarcusSports\Users\Auth\Infrastructure;

use Casbin\Enforcer;
use MarcusSports\Users\Auth\Domain\AuthorizationServiceInterface;

final class CasbinAuthorizationService implements AuthorizationServiceInterface
{
    private Enforcer $enforcer;

    public function __construct(Enforcer $enforcer)
    {
        $this->enforcer = $enforcer;
    }

    public function isAllowed(string $userId, string $resource, string $action): bool
    {
        return $this->enforcer->enforce($userId, $resource, $action);
    }
}
