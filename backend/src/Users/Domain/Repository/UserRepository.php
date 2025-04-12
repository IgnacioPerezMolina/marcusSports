<?php

declare(strict_types=1);


namespace MarcusSports\Users\Domain\Repository;

use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\UserId;

interface UserRepository
{
    public function save(User $user): void;
    public function find(UserId $id): ?User;
//    public function getByCriteria(Criteria $criteria): PaginatedResult;






}