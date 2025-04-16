<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Domain;

use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRuleCollection;
use MarcusSports\Catalog\PartType\Domain\PartTypeCollection;
use MarcusSports\Shared\Domain\Aggregate\AggregateRoot;

class Product extends AggregateRoot
{
    private ProductUuid $id;
    private ProductName $name;
    private ProductDescription $description;
    private ProductCategory $category;
    private ProductBasePrice $basePrice;
    private ?PartTypeCollection $partTypes;
    private ?CompatibilityRuleCollection $rules;
    private ProductCreatedAt $createdAt;
    private ProductUpdatedAt $updatedAt;
    private ?ProductDeletedAt $deletedAt;

    public function __construct(
        ProductUuid                 $id,
        ProductName                 $name,
        ProductDescription          $description,
        ProductCategory             $category,
        ProductBasePrice            $basePrice,
        ?PartTypeCollection          $partTypes,
        ?CompatibilityRuleCollection $rules,
        ProductCreatedAt           $createdAt,
        ProductUpdatedAt           $updatedAt,
        ?ProductDeletedAt          $deletedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->basePrice = $basePrice;
        $this->partTypes = $partTypes;
        $this->rules = $rules;
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

    public function partTypes(): PartTypeCollection
    {
        return $this->partTypes;
    }

    public function rules(): CompatibilityRuleCollection
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
}