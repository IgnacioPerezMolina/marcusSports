<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Application\Create;

final class CreateProductRequest
{
    private string $id;
    private string $name;
    private string $description;
    private string $category;
    private float $basePrice;

    public function __construct(string $id, string $name, string $description, string $category, float $basePrice)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->basePrice = $basePrice;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function basePrice(): float
    {
        return $this->basePrice;
    }
}