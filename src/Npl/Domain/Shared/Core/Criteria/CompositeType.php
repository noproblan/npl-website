<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

enum CompositeType: string
{
    case AND = 'AND';
    case OR = 'OR';

    public function getValue(): string
    {
        return $this->value;
    }
}
