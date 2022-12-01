<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

use Npl\Domain\Shared\Core\Collection;

use function Lambdish\Phunctional\map;

/**
 * @extends Collection<Filter>
 */
class Filters extends Collection implements Filter
{
    public static function fromValues(array $values): self
    {
        return new self(
            array_map(
                self::filterBuilder(),
                $values
            )
        );
    }

    private static function filterBuilder(): callable
    {
        return function (array $values) {
            $factory = FilterFactory::getInstance();
            return $factory::fromValues($values);
        };
    }

    public function getType(): string
    {
        return self::class;
    }

    public function toValues(): array
    {
        return map(
            fn(Filter $filter) => $filter->toValues(),
            $this->getItems()
        );
    }

    public function add(Filter $filter): self
    {
        return new self(
            array_merge(
                $this->getItems(),
                [$filter]
            )
        );
    }

    /**
     * @return Filter[]
     */
    public function getFilters(): array
    {
        return $this->getItems();
    }

    public function serialize(): string
    {
        return array_reduce(
            $this->getFilters(),
            static fn(string $accumulate, Filter $filter) => sprintf('%s^%s', $accumulate, $filter->serialize()),
            ''
        );
    }

    protected function getCollectionType(): string
    {
        return Filter::class;
    }
}
