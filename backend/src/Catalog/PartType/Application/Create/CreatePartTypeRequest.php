<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Application\Create;

final class CreatePartTypeRequest
{
    private string $id;
    private string $name;
    private string $productId;
    private bool $required;
    public function __construct(string $id, string $name, string $productId, bool $required)
    {

        $this->id = $id;
        $this->name = $name;
        $this->productId = $productId;
        $this->required = $required;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }
}