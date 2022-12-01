<?php

declare(strict_types=1);

namespace Tests\Domain\Ticket\Application\TicketReservation;

use Npl\Domain\Ticket\Application\TicketReservation\TicketReservationCommand;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Domain\Ticket\Application\TicketReservation\TicketReservationCommand
 */
class TicketReservationCommandTest extends TestCase
{
    private TicketReservationCommand $command;

    public function testGetLanId()
    {
        static::assertEquals(1, $this->command->getLanId());
    }

    public function testGetUserId()
    {
        static::assertEquals(1, $this->command->getUserId());
    }

    protected function setUp(): void
    {
        $this->command = new TicketReservationCommand(1, 1);

        parent::setUp();
    }
}

