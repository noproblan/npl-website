<?php

declare(strict_types=1);

namespace Npl\Infrastructure\Persistence;

use Npl\Domain\Shared\Core\Criteria\CompositeFilter;
use Npl\Domain\Shared\Core\Criteria\Filter;
use Npl\Domain\Shared\Core\Criteria\FilterOperator;
use Npl\Domain\Shared\Core\Criteria\ValueFilter;
use UnexpectedValueException;

final class FilterToWhereConverter
{
    private string $where;
    private array $bindValues = [];

    private function __construct(Filter $filter)
    {
        switch (true) {
            case $filter instanceof ValueFilter:
                $this->fromValueFilter($filter);
                break;
            case $filter instanceof CompositeFilter:
                $this->fromCompositeFilter($filter);
                break;
            default:
                throw new UnexpectedValueException(
                    sprintf('No mapping for filter of type %s', $filter->getType())
                );
        }
    }

    private function fromValueFilter(ValueFilter $filter): void
    {
        $field = $filter->getField()->getValue();
        $operator = $filter->getOperator();

        if ($operator->isEmpty()) {
            $this->where = 'IS_NULL(`' . $field . '`)';
        } elseif ($operator->isContaining()) {
            $notModifier = $operator === FilterOperator::NOT_CONTAINS ? ' NOT' : '';
            $values = explode(',', $filter->getValue()->getValue());
            $values = array_map(function ($value) {
                return trim($value);
            }, $values);
            $this->where = '`' . $field . '`' . $notModifier . ' IN (:' . $field . ')';
            $this->bindValues[$field] = $values;
        } else {
            $operatorValue = $operator->getValue();
            $this->where = '`' . $field . '` ' . $operatorValue . ' :' . $field;
            $this->bindValues[$field] = $filter->getValue()->getValue();
        }
    }

    private function fromCompositeFilter(CompositeFilter $filter): void
    {
        $whereStatements = [];
        $bindValues = [];

        $compositeType = $filter->getCompositeType();
        $separator = ' ' . mb_strtoupper($compositeType->getValue()) . ' ';
        $filters = $filter->getFilters()->getFilters();

        foreach ($filters as $filter) {
            $converter = self::from($filter);
            $whereStatements[] = $converter->getWhere();
            $bindValues = array_merge($bindValues, $converter->getBindValues());
        }

        $this->where = '(' . implode($separator, $whereStatements) . ')';
        $this->bindValues = $bindValues;
    }

    public static function from(Filter $filter): self
    {
        return new self($filter);
    }

    public function getWhere(): string
    {
        return $this->where;
    }

    public function getBindValues(): array
    {
        return $this->bindValues;
    }
}
