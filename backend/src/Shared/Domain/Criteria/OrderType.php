<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Criteria;

enum OrderType: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    public static function getAllowedOperators(): array
    {
        return array_map(
            fn(self $operator) => $operator->value,
            self::cases()
        );
    }

    public function value(): string
    {
        return $this->value;
    }
}
