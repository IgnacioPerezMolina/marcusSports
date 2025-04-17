<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartItem\Domain;

use MarcusSports\Catalog\PartType\Domain\PartType;
use MarcusSports\Shared\Domain\Aggregate\Aggregate;

class PartItem extends Aggregate
{
    private PartItemUuid $id;
    private PartType $partTypeId;
    private PartItemLabel $label;
    private PartItemPrice $price;
    private PartItemStatus $status;
    private ?PartItemAttributes $attributes;
    private ?PartItemRestrictions $restrictions;
    private PartItemCreatedAt $createdAt;
    private PartItemUpdatedAt $updatedAt;
    private ?PartItemDeletedAt $deletedAt;


    public function __construct(
        PartItemUuid          $id,
        PartType              $partTypeId,
        PartItemLabel         $label,
        PartItemPrice         $price,
        PartItemStatus        $status,
        ?PartItemAttributes   $attributes,
        ?PartItemRestrictions $restrictions,
        PartItemCreatedAt     $createdAt,
        PartItemUpdatedAt     $updatedAt,
        ?PartItemDeletedAt    $deletedAt
    )
    {
        $this->id = $id;
        $this->partTypeId = $partTypeId;
        $this->label = $label;
        $this->price = $price;
        $this->status = $status;
        $this->attributes = $attributes;
        $this->restrictions = $restrictions;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function id(): PartItemUuid
    {
        return $this->id;
    }

    public function partTypeId(): PartType
    {
        return $this->partTypeId;
    }

    public function label(): PartItemLabel
    {
        return $this->label;
    }

    public function price(): PartItemPrice
    {
        return $this->price;
    }

    public function status(): PartItemStatus
    {
        return $this->status;
    }

    public function attributes(): ?PartItemAttributes
    {
        return $this->attributes;
    }

    public function restrictions(): ?PartItemRestrictions
    {
        return $this->restrictions;
    }

    public function createdAt(): PartItemCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): PartItemUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?PartItemDeletedAt
    {
        return $this->deletedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'partTypeId' => $this->partTypeId->id()->value(),
            'label' => $this->label->value(),
            'price' => $this->price->value(),
            'status' => $this->status->value(),
            'attributes' => $this->attributes?->toArray(),
            'restrictions' => $this->restrictions?->toArray(),
            'createdAt' => $this->createdAt->value()->format('c'),
            'updatedAt' => $this->updatedAt->value()->format('c'),
            'deletedAt' => $this->deletedAt && $this->deletedAt->value() ? $this->deletedAt->value()->format('c') : null,
        ];
    }
}