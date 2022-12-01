<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

use JetBrains\PhpStorm\ArrayShape;

final class ValueFilter implements Filter
{
    public function __construct(
        private readonly FilterField $field,
        private readonly FilterOperator $operator,
        private readonly FilterValue $value
    ) {
    }

    public static function fromValues(array $values): self
    {
        return new self(
            new FilterField((string)$values['field']),
            FilterOperator::from((string)$values['operator']),
            new FilterValue((string)$values['value'])
        );
    }

    #[ArrayShape([
        'filterType' => 'string',
        'field' => '\Npl\Domain\Shared\Core\Criteria\FilterField',
        'operator' => '\Npl\Domain\Shared\Core\Criteria\FilterOperator',
        'value' => '\Npl\Domain\Shared\Core\Criteria\FilterValue'
    ])]
    public function toValues(): array
    {
        return [
            'filterType' => $this->getType(),
            'field' => $this->getField()->getValue(),
            'operator' => $this->getOperator()->getValue(),
            'value' => $this->getValue()->getValue()
        ];
    }

    public function getType(): string
    {
        return self::class;
    }

    public function getValue(): FilterValue
    {
        return $this->value;
    }

    public function getField(): FilterField
    {
        return $this->field;
    }

    public function getOperator(): FilterOperator
    {
        return $this->operator;
    }

    public function serialize(): string
    {
        return sprintf(
            '%s.%s.%s',
            $this->field->getValue(),
            $this->operator->getValue(),
            $this->value->getValue()
        );
    }
}
