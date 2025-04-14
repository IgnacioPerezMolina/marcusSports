<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Infrastructure\Repository;

class OperatorMapper
{
    public static function mapOperator(string $operator): string
    {
        return match($operator) {
            '=' => '=',
            '!=' => '<>',
            '>' => '>',
            '<' => '<',
            '>=' => '>=',
            '<=' => '<=',
            'LIKE' => 'LIKE',
            'IN' => 'IN',
            'NOT IN' => 'NOT IN',
            default => throw new \InvalidArgumentException("Not supported operator: $operator")
        };
    }
}