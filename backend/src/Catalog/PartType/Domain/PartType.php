<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use MarcusSports\Catalog\Product\Domain\Product;
use MarcusSports\Shared\Domain\Aggregate\AggregateRoot;
use MarcusSports\Shared\Domain\Helper\RelationConverter;

class PartType extends AggregateRoot
{
    private PartTypeUuid $id;
    private PartTypeName $name;
    private Product $productId;
    private PartTypeRequired $required;

    private ?Collection $partItems;
    private PartTypeCreatedAt $createdAt;
    private PartTypeUpdatedAt $updatedAt;
    private ?PartTypeDeletedAt $deletedAt;

    public function __construct(
        PartTypeUuid       $id,
        PartTypeName       $name,
        Product        $productId,
        PartTypeRequired   $required,
        ?Collection $partItems,
        PartTypeCreatedAt  $createdAt,
        PartTypeUpdatedAt  $updatedAt,
        ?PartTypeDeletedAt $deletedAt
    )
    {

        $this->id = $id;
        $this->name = $name;
        $this->productId = $productId;
        $this->required = $required;
        $this->partItems = $partItems ?? new ArrayCollection();
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function id(): PartTypeUuid
    {
        return $this->id;
    }

    public function name(): PartTypeName
    {
        return $this->name;
    }

    public function productId(): Product
    {
        return $this->productId;
    }

    public function partItems(): Collection
    {
        return $this->partItems;
    }

    public function required(): PartTypeRequired
    {
        return $this->required;
    }

    public function createdAt(): PartTypeCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): PartTypeUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?PartTypeDeletedAt
    {
        return $this->deletedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'productId' => $this->productId->id()->value(),
            'required' => $this->required->value(),
            'partItems' => RelationConverter::convert($this->partItems),
            'createdAt' => $this->createdAt->value()->format('c'),
            'updatedAt' => $this->updatedAt->value()->format('c'),
            'deletedAt' => $this->deletedAt && $this->deletedAt->value() ? $this->deletedAt->value()->format('c') : null,
        ];
    }
}