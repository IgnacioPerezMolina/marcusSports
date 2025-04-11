<?php

declare(strict_types=1);


namespace MarcusSports\Users\Domain\Repository;

use MarcusSports\Users\Domain\User;

interface UserRepository
{
    public function save(User $user): void;
}