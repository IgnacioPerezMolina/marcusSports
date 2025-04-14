<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Domain;

use InvalidArgumentException;
use Iterator;
use OutOfBoundsException;
use UnderflowException;
use UnexpectedValueException;

class Collection implements Iterator
{
    private array $items;
    private ?string $type;

    private mixed $current = null;

    protected function __construct(array $items, string $type)
    {
        $this->type = $type;
        $this->items = $items;
    }

    public static function of(string $type): self
    {
        return new self([], $type);
    }

    public function append(mixed $element): void
    {
        $this->guardAgainstInvalidType($element);
        $this->items[] = $element;
    }

    private function guardAgainstInvalidType(mixed $element): void
    {
        if (!is_object($element)) {
            throw new UnexpectedValueException('Element must be an object');
        }
        if (empty($this->type())) {
            return;
        }
        if (!$this->isSupportedType($element)) {
            throw new UnexpectedValueException('Invalid Type ' . $this->type());
        }
    }

    public function each(callable $function): Collection
    {
        if (!count($this->items) > 0) {
            return $this;
        }
        array_walk($this->items, $function);

        return $this;
    }

    public function map(callable $function): Collection
    {
        if ($this->count() === 0) {
            return clone $this;
        }

        $first = $function(reset($this->items));
        $mapped = Collection::of(get_class($first));
        $mapped->append($first);

        while ($object = next($this->items)) {
            $mapped->append($function($object));
        }

        return $mapped;
    }

    public function filter(callable $function): Collection
    {
        $filtered = Collection::of($this->type());
        if ($this->count() === 0) {
            return $filtered;
        }

        foreach ($this->items as $item) {
            if ($function($item)) {
                $filtered->append($item);
            }
        }

        return $filtered;
    }

    public function getBy(callable $function): mixed
    {
        if ($this->count() === 0) {
            throw new UnderflowException('Collection is empty');
        }

        foreach ($this->items as $item) {
            if ($function($item)) {
                return $item;
            }
        }

        throw new OutOfBoundsException('Element not found');
    }

    public function reduce(callable $function, mixed $initial): mixed
    {
        if ($this->count() === 0) {
            return $initial;
        }
        foreach ($this->items as $item) {
            $initial = $function($item, $initial);
        }
        return $initial;
    }

    public static function collect(array $elements): Collection
    {
        if (empty($elements)) {
            throw new InvalidArgumentException('Can\'t collect an empty array');
        }
        $type = get_class($elements[0]);
        $collection = Collection::of($type);
        array_map(function ($element) use ($collection) {
            $collection->append($element);
        }, $elements);
        return $collection;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        if (count($this->items) === 0) {
            return [];
        }
        return $this->all();
    }

    public function mapToArray(callable $function = null): array
    {
        if (count($this->items) === 0) {
            return [];
        }
        if (!$function) {
            return $this->items;
        }

        return array_map($function, $this->items);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function current(): mixed
    {
        return $this->current;
    }

    public function next(): void
    {
        $next = next($this->items);
        $this->current = $next;
    }

    public function key(): mixed
    {
        return array_key_last($this->items);
    }

    public function valid(): bool
    {
        return next($this->items) != null;
    }

    public function rewind(): void
    {
        // TODO: Implement rewind() method.
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function type(): ?string
    {
        return ucwords($this->type);
    }

    protected function isSupportedType($element): bool
    {
        return is_a($element, $this->type());
    }
}