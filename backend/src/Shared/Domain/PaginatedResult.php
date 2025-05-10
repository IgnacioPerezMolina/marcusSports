<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain;

class PaginatedResult
{
    public function __construct(
        private mixed $items,
        private int   $total,
        private int   $currentPage,
        private int   $itemsPerPage
    ) {
    }

    public function totalPages(): int
    {
        return (int) ceil($this->total / $this->itemsPerPage);
    }

    public function items(): mixed
    {
        return $this->items;
    }
    public function total(): int
    {
        return $this->total;
    }
    public function currentPage(): int
    {
        return $this->currentPage;
    }
    public function itemsPerPage(): int
    {
        return $this->itemsPerPage;
    }
    public function toArray(): array
    {
        return [
            'data' => $this->items,
            'meta' => $this->meta(),
        ];
    }

    public function meta(): array
    {
        return [
            'total' => $this->total,
            'totalPages' => $this->totalPages(),
            'currentPage' => $this->currentPage,
            'itemsPerPage' => $this->itemsPerPage,
        ];
    }
}