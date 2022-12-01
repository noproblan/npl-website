<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

enum OrderType: string
{
    case ASC = 'asc';
    case DESC = 'desc';
    case NONE = 'none';

    public function getValue(): string
    {
        return $this->value;
    }

    public function isNone(): bool
    {
        return $this === self::NONE;
    }
}
