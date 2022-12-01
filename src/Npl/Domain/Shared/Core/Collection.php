<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core;

use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * @template T
 */
abstract class Collection implements Countable, IteratorAggregate
{
    /**
     * @param T[] $items
     * @psalm-assert T[] $items
     */
    public function __construct(protected readonly array $items)
    {
    }

    abstract protected function getCollectionType(): string;

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getItems());
    }

    /**
     * @return T[]
     */
    protected function getItems(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->getItems());
    }
}
