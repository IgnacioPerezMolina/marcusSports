<?php

declare(strict_types=1);


namespace MarcusSports\Users\User\Application\SearchByCriteria;

final readonly class SearchUsersByCriteriaRequest
{
    public function __construct(
        private array $filters,
        private ?string $orderBy,
        private ?string $order,
        private ?int $pageSize,
        private ?int $pageNumber
    ) {}

    public function filters(): array
    {
        return $this->filters;
    }

    public function orderBy(): ?string
    {
        return $this->orderBy;
    }

    public function order(): ?string
    {
        return $this->order;
    }

    public function pageSize(): ?int
    {
        return $this->pageSize;
    }

    public function pageNumber(): ?int
    {
        return $this->pageNumber;
    }
}