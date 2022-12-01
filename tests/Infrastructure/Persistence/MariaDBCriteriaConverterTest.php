<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence;

use Aura\SqlQuery\Common\SelectInterface;
use Aura\SqlQuery\QueryFactory;
use Npl\Domain\Shared\Core\Criteria\CompositeFilter;
use Npl\Domain\Shared\Core\Criteria\CompositeType;
use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Criteria\FilterField;
use Npl\Domain\Shared\Core\Criteria\FilterOperator;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\FilterValue;
use Npl\Domain\Shared\Core\Criteria\Order;
use Npl\Domain\Shared\Core\Criteria\OrderBy;
use Npl\Domain\Shared\Core\Criteria\OrderType;
use Npl\Domain\Shared\Core\Criteria\ValueFilter;
use Npl\Infrastructure\Persistence\MariaDBCriteriaConverter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Infrastructure\Persistence\MariaDBCriteriaConverter
 */
class MariaDBCriteriaConverterTest extends TestCase
{
    private MockObject $order;
    private MockObject $criteria;
    private SelectInterface $select;

    protected function setUp(): void
    {
        $this->order = $this->createMock(Order::class);
        $this->criteria = $this->createMock(Criteria::class);
        $factory = new QueryFactory('mysql');
        $this->select = $factory->newSelect()
            ->from('some_table')
            ->cols(['*']);
        parent::setUp();
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::isEmpty
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::__construct
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::from
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::fromValueFilter
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::getBindValues
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::getWhere
     */
    public function testConvertSimpleFilter()
    {
        $valueFilter = $this->createMock(ValueFilter::class);
        $filterField = $this->createMock(FilterField::class);
        $filterField
            ->expects(static::once())
            ->method('getValue')
            ->willReturn('the_field');
        $valueFilter
            ->expects(static::once())
            ->method('getField')
            ->willReturn($filterField);
        $valueFilter
            ->expects(static::once())
            ->method('getOperator')
            ->willReturn(FilterOperator::EMPTY);
        $this->criteria
            ->expects(static::once())
            ->method('getPlainFilters')
            ->willReturn([$valueFilter]);
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::NONE);

        $select = MariaDBCriteriaConverter::create($this->select, $this->criteria)->getRestrictedSelect();
        static::assertStringContainsString('WHERE', $select->getStatement());
        static::assertStringContainsString('IS_NULL(`the_field`)', $select->getStatement());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\CompositeType::getValue
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::getValue
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::isContaining
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterOperator::isEmpty
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::__construct
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::from
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::fromCompositeFilter
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::fromValueFilter
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::getBindValues
     * @covers \Npl\Infrastructure\Persistence\FilterToWhereConverter::getWhere
     */
    public function testConvertComplexFilter()
    {
        $valueFilterOne = $this->createMock(ValueFilter::class);
        $filterField = $this->createMock(FilterField::class);
        $filterField
            ->expects(static::exactly(2))
            ->method('getValue')
            ->willReturn('the_field');
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
            ->willReturn(FilterOperator::EQUAL);
        $filterValue = $this->createMock(FilterValue::class);
        $filterValue
            ->expects(static::once())
            ->method('getValue')
            ->willReturn('something');
        $valueFilterTwo
            ->expects(static::once())
            ->method('getValue')
            ->willReturn($filterValue);
        $compositeFilter = $this->createMock(CompositeFilter::class);
        $filters = $this->createMock(Filters::class);
        $filters
            ->expects(static::once())
            ->method('getFilters')
            ->willReturn([$valueFilterOne, $valueFilterTwo]);
        $compositeFilter
            ->expects(static::once())
            ->method('getFilters')
            ->willReturn($filters);
        $compositeFilter
            ->expects(static::once())
            ->method('getCompositeType')
            ->willReturn(CompositeType::OR);
        $this->criteria
            ->expects(static::once())
            ->method('getPlainFilters')
            ->willReturn([$compositeFilter]);
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::NONE);

        $select = MariaDBCriteriaConverter::create($this->select, $this->criteria)->getRestrictedSelect();
        static::assertStringContainsString('WHERE', $select->getStatement());
        static::assertStringContainsString(
            '(IS_NULL(`the_field`) OR `the_field` = :the_field)',
            $select->getStatement()
        );
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::getValue
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     */
    public function testConvertsOrder()
    {
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::ASC);
        $orderBy = $this->createMock(OrderBy::class);
        $this->order
            ->expects(static::once())
            ->method('getOrderBy')
            ->willReturn($orderBy);
        $orderBy
            ->expects(static::once())
            ->method('getValue')
            ->willReturn('field_name');

        $select = MariaDBCriteriaConverter::create($this->select, $this->criteria)->getRestrictedSelect();
        static::assertStringContainsString('ORDER BY', $select->getStatement());
        static::assertStringContainsString('field_name asc', $select->getStatement());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     */
    public function testConvertsOrderNoneToEmptyString()
    {
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::NONE);

        $select = MariaDBCriteriaConverter::create($this->select, $this->criteria)->getRestrictedSelect();
        static::assertStringNotContainsString('ORDER', $select->getStatement());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     */
    public function testConvertsLimit()
    {
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::NONE);
        $this->criteria
            ->expects(static::once())
            ->method('getLimit')
            ->willReturn(1);

        $select = MariaDBCriteriaConverter::create($this->select, $this->criteria)->getRestrictedSelect();
        static::assertStringContainsString('LIMIT 1', $select->getStatement());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     */
    public function testConvertsOffsetWithoutLimitToEmptyString()
    {
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::NONE);

        $select = MariaDBCriteriaConverter::create($this->select, $this->criteria)->getRestrictedSelect();
        static::assertStringNotContainsString('LIMIT', $select->getStatement());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     */
    public function testConvertsOffsetAndLimit()
    {
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::NONE);
        $this->criteria
            ->expects(static::once())
            ->method('getLimit')
            ->willReturn(2);
        $this->criteria
            ->expects(static::once())
            ->method('getOffset')
            ->willReturn(3);

        $select = MariaDBCriteriaConverter::create($this->select, $this->criteria)->getRestrictedSelect();
        static::assertStringContainsString('LIMIT 2 OFFSET 3', $select->getStatement());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Criteria\OrderType::isNone
     */
    public function testGetRestrictedSelect()
    {
        $this->criteria
            ->expects(static::once())
            ->method('getOrder')
            ->willReturn($this->order);
        $this->order
            ->expects(static::once())
            ->method('getOrderType')
            ->willReturn(OrderType::NONE);
        $converter = MariaDBCriteriaConverter::create($this->select, $this->criteria);
        static::assertEquals($this->select, $converter->getRestrictedSelect());
    }
}

