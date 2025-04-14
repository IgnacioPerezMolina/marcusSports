<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Criteria;

final readonly class Filter
{
    public function __construct(
        private string $field,
        private FilterOperator $operator,
        private mixed  $value
    ) {
    }

    public function field(): string
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public static function create(string $field,
                                  string $operator,
                                  mixed  $value): self
    {
        return new self($field, FilterOperator::fromValue($operator), $value);
    }
    /*public static function fromPrimitives(string $field, mixed $value): self
    {
        return new self(
            field: $field,
            operator: FilterOperator::EQUAL,
            value: $value
        );
    }*/
    public static function fromPrimitives(
        string $field,
        string $operator,
        mixed $value,
    ): self
    {
        return new self(
            field: $field,
            operator: FilterOperator::fromValue($operator),
            value: $value
        );
    }
}