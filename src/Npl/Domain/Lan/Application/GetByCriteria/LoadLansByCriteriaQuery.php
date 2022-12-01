<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Application\GetByCriteria;

use Npl\Domain\Shared\Core\Bus\Query\Query;

final class LoadLansByCriteriaQuery implements Query
{
    public function __construct(
        private readonly array $filters,
        private readonly ?string $orderBy,
        private readonly ?string $order,
        private readonly ?int $limit,
        private readonly ?int $offset
    ) {
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }
}
