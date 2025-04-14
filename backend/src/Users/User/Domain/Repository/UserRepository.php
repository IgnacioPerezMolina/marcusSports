<?php

declare(strict_types=1);


namespace MarcusSports\Users\User\Domain\Repository;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserUuid;

interface UserRepository
{
    public function save(User $user): void;
    public function find(UserUuid $uuid): ?User;
    public function findByEmail(UserEmail $userEmail): ?User;
    public function getByCriteria(Criteria $criteria): PaginatedResult;






}