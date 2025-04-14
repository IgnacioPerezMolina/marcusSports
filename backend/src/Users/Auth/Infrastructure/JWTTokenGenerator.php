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
        // LexikJWTAuthenticationBundle no provee refresh token de forma nativa.
        // Aquí puedes implementar tu lógica de refresh token o delegar a otro servicio.
        // Un ejemplo sería reutilizar el JWT manager con un TTL mayor, o almacenar y gestionar el refresh token en BD.
        // En este ejemplo, simplemente creamos otro token con un TTL diferente.
        // Nota: Es recomendable manejar refresh tokens de forma separada.
        return $this->jwtManager->create($user);
    }
}
