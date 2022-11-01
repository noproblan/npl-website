<?php

namespace Tests\Ticket;

use Npl\Ticket\InvalidTicketStatus;
use Npl\Ticket\OwnerMismatchException;
use Npl\Ticket\Ticket;
use Npl\Ticket\TicketDTO;
use Npl\Ticket\TicketStatus;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Ticket\Ticket
 */
class TicketTest extends TestCase
{
    private TicketDTO $ticketDTO;
    private Ticket $ticket;

    protected function setUp(): void
    {
        $this->ticketDTO = new TicketDTO();
        $this->ticketDTO->lanId = 1;
        $this->ticketDTO->userId = 1;
        $this->ticketDTO->status = TicketStatus::NOT_PAID;
        $this->ticket = Ticket::fromDTO($this->ticketDTO);
        parent::setUp();
    }

    public function testConstructFromAnew(): void
    {
        $ticket = Ticket::new(1);
        $ticketDTO = new TicketDTO();
        $ticketDTO->lanId = 1;
        $ticketDTO->status = TicketStatus::NOT_PAID;
        $expected = Ticket::fromDTO($ticketDTO);
        $this->assertEquals($expected, $ticket);
    }

    public function testConstructFromDTOThrowsInvalidTicketStatus(): void
    {
        $this->expectException(InvalidTicketStatus::class);
        $this->expectExceptionMessage('Passed ticket status is not valid');
        $ticketDTO = new TicketDTO();
        $ticketDTO->status = 'invalid status';
        Ticket::fromDTO($ticketDTO);
    }

    public function testConstructFromDTO(): void
    {
        $expected = Ticket::fromDTO($this->ticketDTO);
        $this->assertEquals($expected, $this->ticket);
    }

    public function testTransferThrowsOwnerMismatchWhenOwnerIsIncorrect(): void
    {
        $this->expectException(OwnerMismatchException::class);
        $this->expectExceptionMessage('Ticket is not owned by provided owner');
        $this->ticket->transfer(2, 2);
    }

    public function testTransferToTransferCorrectly(): void
    {
        $ticketDTO = new TicketDTO();
        $ticketDTO->lanId = 1;
        $ticketDTO->userId = 2;
        $ticketDTO->status = TicketStatus::NOT_PAID;
        $expectedTicket = Ticket::fromDTO($ticketDTO);
        $this->ticket->transfer(1, 2);
        $this->assertEquals($expectedTicket, $this->ticket);
    }

    public function testAddExtraToAddNewExtra(): void
    {
        $this->ticket->addExtra('something');
        $this->assertEquals(['something'], $this->ticket->getExtras());
    }

    public function testAddExtraOnlysAddsNonDuplicates(): void
    {
        $this->ticket->addExtra('something');
        $this->ticket->addExtra('another something');
        $this->ticket->addExtra('something');
        $this->assertEquals(['something', 'another something'], $this->ticket->getExtras());
    }

    public function testRemoveExtrasDoesNotAlterIfExtraIsNotExisting(): void
    {
        $this->ticket->addExtra('existent');
        $this->ticket->removeExtra('inexistent');
        $this->assertEquals(['existent'], $this->ticket->getExtras());
    }

    public function testRemoveExtrasRemovesTheExtra(): void
    {
        $this->ticket->addExtra('existent');
        $this->ticket->addExtra('something');
        $this->ticket->removeExtra('existent');
        $this->assertEquals(['something'], $this->ticket->getExtras());
    }

    public function testMarkAsPaidThrowsInvalidTicketStatusWhenNotPaid(): void
    {
        $this->ticket->markAsPrepaid();
        $this->expectException(InvalidTicketStatus::class);
        $this->expectExceptionMessage('Ticket is already marked as paid');
        $this->ticket->markAsPaid();
    }

    public function testMarkAsPaidUpdatesTheStatusCorrectly(): void
    {
        $this->assertEquals(TicketStatus::NOT_PAID, $this->ticket->getStatus());
        $this->ticket->markAsPaid();
        $this->assertEquals(TicketStatus::PAID, $this->ticket->getStatus());
    }

    public function testMarkAsPrepaidThrowsInvalidTicketStatusWhenNotPaid(): void
    {
        $this->ticket->markAsPrepaid();
        $this->expectException(InvalidTicketStatus::class);
        $this->expectExceptionMessage('Ticket is already marked as paid');
        $this->ticket->markAsPrepaid();
    }

    public function testMarkAsPrepaidUpdatesTheStatusCorrectly(): void
    {
        $this->assertEquals(TicketStatus::NOT_PAID, $this->ticket->getStatus());
        $this->ticket->markAsPrepaid();
        $this->assertEquals(TicketStatus::PREPAID, $this->ticket->getStatus());
    }
}
