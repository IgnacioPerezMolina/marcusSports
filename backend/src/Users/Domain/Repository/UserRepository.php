<?php

declare(strict_types=1);


namespace MarcusSports\Users\Domain\Repository;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\UserUuid;

interface UserRepository
{
    public function save(User $user): void;
    public function find(UserUuid $uuid): ?User;
    public function getByCriteria(Criteria $criteria): PaginatedResult;






}