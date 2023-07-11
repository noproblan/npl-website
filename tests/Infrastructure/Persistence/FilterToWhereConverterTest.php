<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence;

use Npl\Domain\Shared\Core\Criteria\CompositeFilter;
use Npl\Domain\Shared\Core\Criteria\CompositeType;
use Npl\Domain\Shared\Core\Criteria\Filter;
use Npl\Domain\Shared\Core\Criteria\FilterField;
use Npl\Domain\Shared\Core\Criteria\FilterOperator;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\FilterValue;
use Npl\Domain\Shared\Core\Criteria\ValueFilter;
use Npl\Infrastructure\Persistence\FilterToWhereConverter;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

/**
 * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter
 */
class FilterToWhereConverterTest extends TestCase
{
    public function testFromUnspecifiedFilterThrowsException(): void
    {
        static::expectException(UnexpectedValueException::class);
        static::expectExceptionMessage('No mapping for filter of type ');

        $filter = $this->createStub(Filter::class);
        FilterToWhereConverter::from($filter);
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\CompositeType::getValue
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::getValue
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::isContaining
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::isEmpty
     */
    public function testFromCompositeFilter(): void
    {
        $valueFilterOne = $this->createMock(ValueFilter::class);
        $filterField = $this->createMock(FilterField::class);
        $filterField
            ->expects(static::exactly(2))
            ->method('getValue')
            ->willReturn('a_field');
        $valueFilterOne
            ->expects(static::once())
            ->method('getField')
            ->willReturn($filterField);
        $valueFilterOne
            ->expects(static::once())
            ->method('getOperator')
            ->willReturn(FilterOperator::EMPTY);
        $valueFilterTwo = $this->createMock(ValueFilter::class);
        $valueFilterTwo
            ->expects(static::once())
            ->method('getField')
            ->willReturn($filterField);
        $valueFilterTwo
            ->expects(static::once())
            ->method('getOperator')
            ->willReturn(FilterOperator::CONTAINS);
        $filterValue = $this->createMock(FilterValue::class);
        $filterValue
            ->expects(static::once())
            ->method('getValue')
            ->willReturn('a,b , c');
        $valueFilterTwo
            ->expects(static::once())
            ->method('getValue')
            ->willReturn($filterValue);
        $filter = $this->createMock(CompositeFilter::class);
        $filters = $this->createMock(Filters::class);
        $filters
            ->expects(static::once())
            ->method('getFilters')
            ->willReturn([$valueFilterOne, $valueFilterTwo]);
        $filter
            ->expects(static::once())
            ->method('getFilters')
            ->willReturn($filters);
        $filter
            ->expects(static::once())
            ->method('getCompositeType')
            ->willReturn(CompositeType::OR);
        $converter = FilterToWhereConverter::from($filter);
        static::assertEquals('(IS_NULL(`a_field`) OR `a_field` IN (:a_field))', $converter->getWhere());
        static::assertEquals(['a_field' => ['a', 'b', 'c']], $converter->getBindValues());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::getValue
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::isContaining
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::isEmpty
     */
    public function testFromValueFilter(): void
    {
        $filter = $this->createMock(ValueFilter::class);
        $filterField = $this->createMock(FilterField::class);
        $filterField
            ->expects(static::once())
            ->method('getValue')
            ->willReturn('a_field');
        $filter
            ->expects(static::once())
            ->method('getField')
            ->willReturn($filterField);
        $filter
            ->expects(static::once())
            ->method('getOperator')
            ->willReturn(FilterOperator::EQUAL);
        $filterValue = $this->createMock(FilterValue::class);
        $filterValue
            ->expects(static::once())
            ->method('getValue')
            ->willReturn('%');
        $filter
            ->expects(static::once())
            ->method('getValue')
            ->willReturn($filterValue);
        $converter = FilterToWhereConverter::from($filter);
        static::assertEquals('`a_field` = :a_field', $converter->getWhere());
        static::assertEquals(['a_field' => '%'], $converter->getBindValues());
    }
}
