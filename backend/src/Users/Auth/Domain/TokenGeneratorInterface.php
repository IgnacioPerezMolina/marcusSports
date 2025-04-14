<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Domain;

use MarcusSports\Users\User\Domain\User;

interface TokenGeneratorInterface
{
    public function generateAccessToken(User $user): string;
    public function generateRefreshToken(User $user): string;
}