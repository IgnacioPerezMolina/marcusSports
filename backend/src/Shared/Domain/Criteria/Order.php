<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Criteria;

final readonly class Order
{
    public function __construct(
        private string    $orderBy,
        private OrderType $orderType
    )
    {
    }

    public function orderBy(): string
    {
        return $this->orderBy;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }

    public static function create(string $orderBy, string $orderType): self
    {
        return new self($orderBy, OrderType::tryFrom($orderType));
    }
}