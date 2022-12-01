<?php

declare(strict_types=1);

namespace Tests\Domain\Shared\Core\Criteria;

use JetBrains\PhpStorm\ArrayShape;
use Npl\Domain\Shared\Core\Criteria\Filter;

class FilterMock implements Filter
{
    public function __construct(
        private readonly string $field,
        private readonly string $operator,
        private readonly string $value
    ) {
    }

    public static function fromValues(array $values): Filter
    {
        return new self(
            $values['field'],
            $values['operator'],
            $values['value']
        );
    }

    #[ArrayShape([
        'filterType' => 'string',
        'field' => 'string',
        'operator' => 'string',
        'value' => 'string'
    ])] public function toValues(): array
    {
        return [
            'filterType' => $this->getType(),
            'field' => $this->field,
            'operator' => $this->operator,
            'value' => $this->value,
        ];
    }

    public function getType(): string
    {
        return self::class;
    }

    public function serialize(): string
    {
        return sprintf(
            '%s.%s.%s',
            $this->field,
            $this->operator,
            $this->value
        );
    }
}
