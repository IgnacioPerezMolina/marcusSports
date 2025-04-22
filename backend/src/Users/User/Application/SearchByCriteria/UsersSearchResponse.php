<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Application\SearchByCriteria;

use MarcusSports\Shared\Domain\PaginatedResult;

final class UsersSearchResponse
{
    public function __construct(
        private readonly PaginatedResult $paginatedResult,
        private readonly array           $filters,
        private readonly ?string         $orderBy,
        private readonly ?string         $order
    )
    {
    }

    public function paginatedResult(): PaginatedResult
    {
        return $this->paginatedResult;
    }

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

    public function toArray(): array
    {
        $users = array_map(function ($user): array {
            return [
                'id' => $user->id()->value(),
                'firstName' => $user->firstName()->value(),
                'lastName' => $user->lastName()->value(),
                'email' => $user->email()->value(),
            ];
        }, $this->paginatedResult->items());

        return [
            'data' => $users,
            'meta' => $this->paginatedResult->meta(),
            'filters' => $this->filters,
            'orderBy' => $this->orderBy,
            'order' => $this->order,
        ];
    }
}