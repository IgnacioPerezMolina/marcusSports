<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Domain;

use MarcusSports\Shared\Domain\Collection;

final class PartItemCollection extends Collection
{
    // TODO review


//    protected ?string $type = PartItem::class;
//
//    public function __construct(array $elements = [])
//    {
//        parent::__construct($elements, $this->type);
//    }

    private array $partItem;

    public function __construct(array $partItem = [])
    {
        $this->partItem = array_filter($partItem, fn($item) => $item instanceof PartItem);
    }

    public function add(PartItem $partItem): void
    {
        $this->partItem[] = $partItem;
    }

    /** @return PartItem[] */
    public function all(): array
    {
        return $this->partItem;
    }

    public function toArray(): array
    {
        return array_map(fn(PartItem $partItem) => $partItem->toArray(), $this->partItem);
    }
}
