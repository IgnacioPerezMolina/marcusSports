<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Criteria;

enum FilterOperator: string
{
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case GT = '>';
    case GTE = '>=';
    case LT = '<';
    case LTE = '<=';
    case CONTAINS = 'LIKE';
    case NOT_CONTAINS = 'NOT LIKE';
    case IN = 'IN';
    case NOT_IN = 'NOT IN';
    case IS_NULL = 'IS NULL';
    case IS_NOT_NULL = 'IS NOT NULL';


    public static function fromValue(?string $value): self
    {
        return match ($value) {
            '=' => self::EQUAL,
            '!=' => self::NOT_EQUAL,
            '>' => self::GT,
            '>=' => self::GTE,
            '<' => self::LT,
            '<=' => self::LTE,
            'LIKE' => self::CONTAINS,
            'NOT LIKE' => self::NOT_CONTAINS,
            'IN' => self::IN,
            'NOT IN' => self::NOT_IN,
            'IS NULL' => self::IS_NULL,
            'IS NOT NULL' => self::IS_NOT_NULL,
            default => throw new \InvalidArgumentException("Operator $value is not valid")
        };
    }

    public function isContains(): bool
    {
        return in_array($this, [self::CONTAINS, self::NOT_CONTAINS], true);
    }

    public function isCollection(): bool
    {
        return in_array($this, [self::IN, self::NOT_IN], true);
    }

    public function isNull(): bool
    {
        return in_array($this, [self::IS_NULL, self::IS_NOT_NULL], true);
    }

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