<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

final class Criteria
{
    public function __construct(
        private readonly Filters $filters,
        private readonly Order $order,
        private readonly ?int $offset,
        private readonly ?int $limit
    ) {
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    /**
     * @return Filter[]
     */
    public function getPlainFilters(): array
    {
        return $this->filters->getFilters();
    }

    public function getFilters(): Filters
    {
        return $this->filters;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function serialize(): string
    {
        return sprintf(
            '%s~~%s~~%s~~%s',
            $this->filters->serialize(),
            $this->order->serialize(),
            $this->offset ?: 'NULL',
            $this->limit ?: 'NULL'
        );
    }
}
