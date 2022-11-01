<?php

namespace Tests\Ticket;

use Npl\Ticket\TicketStatus;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Ticket\TicketStatus
 */
class TicketStatusTest extends TestCase
{
    public function testGetValue()
    {
        $this->assertEquals('prepaid', TicketStatus::PREPAID->getValue());
        $this->assertEquals('paid', TicketStatus::PAID->getValue());
        $this->assertEquals('notpaid', TicketStatus::NOT_PAID->getValue());
    }
}
