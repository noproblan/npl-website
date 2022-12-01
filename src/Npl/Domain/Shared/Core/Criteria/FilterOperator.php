<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

enum FilterOperator: string
{
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case GT = '>';
    case LT = '<';
    case CONTAINS = 'CONTAINS';
    case NOT_CONTAINS = 'NOT_CONTAINS';
    case EMPTY = 'EMPTY';

    public function getValue(): string
    {
        return $this->value;
    }

    public function isContaining(): bool
    {
        return in_array(
            $this,
            [self::CONTAINS, self::NOT_CONTAINS],
            true
        );
    }

    public function isEmpty(): bool
    {
        return $this === self::EMPTY;
    }
}
