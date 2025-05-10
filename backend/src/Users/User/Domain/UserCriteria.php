<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Domain;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\Criteria\Filters;

final readonly class UserCriteria extends Criteria
{
    public static function forRole(string $role): self
    {
        return new self(
            new Filters([
                new Filter(
                    new FilterField('role'),
                    FilterOperator::EQUAL,
                    new FilterValue($role)
                ),
            ]),
            Order::none()
        );

    }
}