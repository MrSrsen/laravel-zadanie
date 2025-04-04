<?php

namespace App\DataObject;

/** @template T of mixed */
class PaginatorResult
{
    /** @param array<T> $items */
    public function __construct(
        public int $totalItems,
        public int $page,
        public int $maxPages,
        public array $items,
    ) {
    }

    public function map(\Closure $closure): static
    {
        return new static(
            totalItems: $this->totalItems,
            page: $this->page,
            maxPages: $this->maxPages,
            items: array_map($closure, $this->items),
        );
    }

    public function toArray(): array
    {
        return [
            'totalItems' => $this->totalItems,
            'page' => $this->page,
            'maxPages' => $this->maxPages,
            'items' => $this->items,
        ];
    }
}
