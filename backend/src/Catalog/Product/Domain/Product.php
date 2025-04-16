<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use MarcusSports\Shared\Domain\Aggregate\AggregateRoot;

class Product extends AggregateRoot
{
    private ProductUuid $id;
    private ProductName $name;
    private ProductDescription $description;
    private ProductCategory $category;
    private ProductBasePrice $basePrice;
    private ?Collection $partTypes;
    private ?Collection $rules;
    private ProductCreatedAt $createdAt;
    private ProductUpdatedAt $updatedAt;
    private ?ProductDeletedAt $deletedAt;

    public function __construct(
        ProductUuid        $id,
        ProductName        $name,
        ProductDescription $description,
        ProductCategory    $category,
        ProductBasePrice   $basePrice,
        ?Collection        $partTypes,
        ?Collection        $rules,
        ProductCreatedAt   $createdAt,
        ProductUpdatedAt   $updatedAt,
        ?ProductDeletedAt  $deletedAt
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->basePrice = $basePrice;
        $this->partTypes = $partTypes ?? new ArrayCollection();
        $this->rules = $rules ?? new ArrayCollection();
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function id(): ProductUuid
    {
        return $this->id;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function description(): ProductDescription
    {
        return $this->description;
    }

    public function category(): ProductCategory
    {
        return $this->category;
    }

    public function basePrice(): ProductBasePrice
    {
        return $this->basePrice;
    }

    public function partTypes(): ArrayCollection
    {
        return $this->partTypes;
    }

    public function rules(): ArrayCollection
    {
        return $this->rules;
    }

    public function createdAt(): ProductCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): ProductUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?ProductDeletedAt
    {
        return $this->deletedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'description' => $this->description->value(),
            'category' => $this->category->value(),
            'basePrice' => $this->basePrice->value(),
            'createdAt' => $this->createdAt->value()->format('c'),
            'updatedAt' => $this->updatedAt->value()->format('c'),
            'deletedAt' => $this->deletedAt && $this->deletedAt->value() ? $this->deletedAt->value()->format('c') : null,
        ];
    }
}