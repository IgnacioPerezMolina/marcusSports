<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Domain;

use MarcusSports\Catalog\Product\Domain\ProductUuid;
use MarcusSports\Shared\Domain\Aggregate\AggregateRoot;

class PartType extends AggregateRoot
{
    private PartTypeUuid $id;
    private PartTypeName $name;
    private ProductUuid $productId;
    private PartTypeRequired $required;
    private PartTypeCreatedAt $createdAt;
    private PartTypeUpdatedAt $updatedAt;
    private ?PartTypeDeletedAt $deletedAt;

    public function __construct(
        PartTypeUuid       $id,
        PartTypeName       $name,
        ProductUuid        $productId,
        PartTypeRequired   $required,
        PartTypeCreatedAt  $createdAt,
        PartTypeUpdatedAt  $updatedAt,
        ?PartTypeDeletedAt $deletedAt
    )
    {

        $this->id = $id;
        $this->name = $name;
        $this->productId = $productId;
        $this->required = $required;
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

    public function productId(): ProductUuid
    {
        return $this->productId;
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
}