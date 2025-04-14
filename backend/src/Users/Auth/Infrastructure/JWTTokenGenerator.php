<?php

declare(strict_types=1);

namespace MarcusSports\Users\Auth\Infrastructure;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use MarcusSports\Users\Auth\Domain\BearerUser;
use MarcusSports\Users\Auth\Domain\TokenGeneratorInterface;

final class JWTTokenGenerator implements TokenGeneratorInterface
{
    private JWTTokenManagerInterface $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function generateAccessToken(BearerUser $user): string
    {
        return $this->jwtManager->create($user);
    }

    public function generateRefreshToken(BearerUser $user): string
    {
        // LexikJWTAuthenticationBundle doesn't generate refresh tokens by default.
        // You can implement refresh token logic here or delegate it to another service.
        // In this example we just create another token with a different TTL.
        // It's best to handle refresh tokens separately.
        return $this->jwtManager->create($user);
    }
}
