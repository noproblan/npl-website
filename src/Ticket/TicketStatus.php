<?php

namespace Npl\Ticket;

enum TicketStatus {
    case PREPAID;
    case PAID;
    case NOT_PAID;

    public function getValue() : string {
        return match($this) {
            self::PREPAID => 'prepaid',
            self::PAID => 'paid',
            self::NOT_PAID => 'notpaid'
        };
    }
}
