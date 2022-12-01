<?php

declare(strict_types=1);

namespace Npl\Infrastructure\Persistence;

use Aura\SqlQuery\Common\SelectInterface;
use Npl\Domain\Shared\Core\Criteria\Criteria;

final class MariaDBCriteriaConverter
{
    private function __construct(
        private readonly SelectInterface $select,
        private readonly Criteria $criteria
    ) {
    }

    public static function create(
        SelectInterface $select,
        Criteria $criteria
    ): self {
        $converter = new self($select, $criteria);
        $converter->addRestrictions();
        return $converter;
    }

    private function addRestrictions(): void
    {
        $this->addWhere();
        $this->addOrder();
        $this->addLimit();
        $this->addOffset();
    }

    private function addWhere(): void
    {
        $filters = $this->criteria->getPlainFilters();

        foreach ($filters as $filter) {
            $converter = FilterToWhereConverter::from($filter);
            $this->select->where($converter->getWhere());
            $this->select->bindValues($converter->getBindValues());
        }
    }

    private function addOrder(): void
    {
        $order = $this->criteria->getOrder();
        $orderType = $order->getOrderType();

        if (!$orderType->isNone()) {
            $orderBy = $order->getOrderBy()->getValue();
            $orderDirection = $orderType->getValue();
            $this->select->orderBy([$orderBy . ' ' . $orderDirection]);
        }
    }

    private function addLimit(): void
    {
        $limit = $this->criteria->getLimit();

        if (null !== $limit) {
            $this->select->limit($limit);
        }
    }

    private function addOffset(): void
    {
        $offset = $this->criteria->getOffset();

        if (null !== $offset) {
            $this->select->offset($offset);
        }
    }

    public function getRestrictedSelect(): SelectInterface
    {
        return $this->select;
    }
}
