<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

enum ExtraType: string
{
    case BREAKFAST = 'breakfast';
    case DINNER = 'dinner';

    public function getValue(): string
    {
        return $this->value;
    }
}
