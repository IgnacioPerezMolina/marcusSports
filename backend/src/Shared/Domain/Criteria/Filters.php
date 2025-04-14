<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Criteria;

class Filters
{
    private array $filters;

    public function __construct(Filter ...$filters)
    {
        $this->filters = $filters;
    }

    public function filters(): array
    {
        return $this->filters;
    }

    private function add(Filter $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    public static function create(array $filters): self
    {
        foreach ($filters as $filter) {
            if (!$filter instanceof Filter) {
                throw new \InvalidArgumentException('All filters must be instances of Filter class');
            }
        }
        return new self(...$filters);
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function fromValues(array $values): self
    {
        $filters = [];
        foreach ($values as $field => $value) {
            if (null !== $value) {
                if ($value instanceof Filter) {
                    $filters[] = $value;
                    continue;
                }
                $filters[] = Filter::fromPrimitives($field, '=', $value);
            }
        }

        return new self(... $filters);
    }
}