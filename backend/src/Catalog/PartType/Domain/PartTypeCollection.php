<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Domain;

use MarcusSports\Shared\Domain\Collection;

final class PartTypeCollection extends Collection
{
    // TODO

//    public ?string $type = PartType::class;
//
//    public function __construct(array $elements = [])
//    {
//        parent::__construct($elements, $this->type);
//    }

    private array $partType;

    public function __construct(array $partType = [])
    {
        $this->partType = array_filter($partType, fn($item) => $item instanceof PartType);
    }

    public function add(PartType $partType): void
    {
        $this->partType[] = $partType;
    }

    /** @return PartType[] */
    public function all(): array
    {
        return $this->partType;
    }

    public function toArray(): array
    {
        return array_map(fn(PartType $partType) => $partType->toArray(), $this->partType);
    }
}