<?php

declare(strict_types=1);

namespace MarcusSports\Users\Auth\Domain;

interface TokenGeneratorInterface
{
    public function generateAccessToken(BearerUser $user): string;
    public function generateRefreshToken(BearerUser $user): string;
}