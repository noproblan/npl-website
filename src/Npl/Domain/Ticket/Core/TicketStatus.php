<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

enum TicketStatus: string
{
    case NOT_PAID = 'not_paid';
    case PREPAID = 'prepaid';
    case PAID = 'paid';

    public function getValue(): string
    {
        return $this->value;
    }

    public function isInPaidState(): bool
    {
        return in_array(
            $this,
            [self::PREPAID, self::PAID],
            true
        );
    }
}
