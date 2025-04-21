<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Domain\Criteria;

class Criteria
{
    public function __construct(
        private readonly ?Filters $filters = null,
        private readonly ?Order   $order = null,
        private readonly ?int     $offset = null,
        private readonly ?int     $limit = null
    ) {
    }

    public function hasFilters(): bool
    {
        return null !== $this->filters;
    }

    public function filters(): ?Filters
    {
        return $this->filters;
    }

    public function order(): ?Order
    {
        return $this->order;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public static function fromFilters(?array $rawFilters = null, ?Order $order = null, ?int $offset = null, ?int $limit = null): self
    {
        return new self(
            filters: $rawFilters ? Filters::fromValues($rawFilters) : null,
            order: $order ?? null,
            offset: $offset ?? null,
            limit: $limit ?? null
        );
    }

    public function currentPage(): int
    {
        return $this->offset() ? ($this->offset() / $this->limit()) + 1 : 1;
    }
}