<?php

declare(strict_types=1);

namespace Tests\Domain\Shared\Core\Criteria;

use Npl\Domain\Shared\Core\Criteria\Filter;
use Npl\Domain\Shared\Core\Criteria\Filters;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Domain\Shared\Core\Criteria\Filters
 */
class FiltersTest extends TestCase
{
    private Filter $mockValueFilter;
    private Filters $filters;

    /**
     * @covers \Npl\Domain\Shared\Core\Collection::__construct
     */
    public function testGetType(): void
    {
        static::assertEquals('Npl\Domain\Shared\Core\Criteria\Filters', $this->filters->getType());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Collection::__construct
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterFactory::__construct
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterFactory::fromValues
     * @covers \Npl\Domain\Shared\Core\Criteria\FilterFactory::getInstance
     */
    public function testFromValues(): void
    {
        $filter = [
            'filterType' => 'Tests\Domain\Shared\Core\Criteria\FilterMock',
            'field' => 'test',
            'operator' => '=',
            'value' => 'something'
        ];
        $expected = new Filters([
            FilterMock::fromValues($filter)
        ]);
        $actual = Filters::fromValues([$filter]);
        static::assertEquals($expected, $actual);
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Collection::__construct
     * @covers \Npl\Domain\Shared\Core\Collection::getItems
     */
    public function testToValues(): void
    {
        static::assertEquals([
            [
                'filterType' => 'Tests\Domain\Shared\Core\Criteria\FilterMock',
                'field' => 'test',
                'operator' => '=',
                'value' => 'something'
            ]
        ], $this->filters->toValues());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Collection::__construct
     * @covers \Npl\Domain\Shared\Core\Collection::count
     * @covers \Npl\Domain\Shared\Core\Collection::getItems
     */
    public function testAdd(): void
    {
        static::assertCount(1, $this->filters->getFilters());
        $newFilters = $this->filters->add($this->createStub(Filter::class));
        static::assertCount(2, $newFilters);
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Collection::__construct
     * @covers \Npl\Domain\Shared\Core\Collection::getItems
     */
    public function testGetFilters(): void
    {
        static::assertEquals([
            $this->mockValueFilter
        ], $this->filters->getFilters());
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Collection::__construct
     * @covers \Npl\Domain\Shared\Core\Collection::getItems
     */
    public function testSerialize(): void
    {
        static::assertEquals('^test.=.something', $this->filters->serialize());
    }

    protected function setUp(): void
    {
        $this->mockValueFilter = new FilterMock('test', '=', 'something');

        $this->filters = new Filters([
            $this->mockValueFilter
        ]);

        parent::setUp();
    }
}
