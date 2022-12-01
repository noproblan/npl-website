<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

use JetBrains\PhpStorm\ArrayShape;

final class CompositeFilter implements Filter
{
    public function __construct(
        private readonly Filters $filters,
        private readonly CompositeType $compositeType
    ) {
    }

    public static function fromValues(array $values): self
    {
        return new self(
            Filters::fromValues((array)$values['filters']),
            CompositeType::from((string)$values['compositeType'])
        );
    }

    #[ArrayShape([
        'filterType' => 'string',
        'filters' => 'array',
        'compositeType' => '\Npl\Domain\Shared\Core\Criteria\CompositeType'
    ])]
    public function toValues(): array
    {
        return [
            'filterType' => $this->getType(),
            'filters' => $this->getFilters()->toValues(),
            'compositeType' => $this->getCompositeType()->getValue()
        ];
    }

    public function getType(): string
    {
        return self::class;
    }

    public function getFilters(): Filters
    {
        return $this->filters;
    }

    public function getCompositeType(): CompositeType
    {
        return $this->compositeType;
    }

    public function serialize(): string
    {
        return array_reduce(
            $this->getFilters()->getFilters(),
            static fn(string $accumulate, Filter $filter) => sprintf('%s^%s', $accumulate, $filter->serialize()),
            ''
        );
    }
}
