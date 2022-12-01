<?php

declare(strict_types=1);

namespace Tests\Domain\Ticket\Application\TicketReservation;

use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\User\UserId;
use Npl\Domain\Ticket\Application\TicketReservation\TicketReservationCommand;
use Npl\Domain\Ticket\Application\TicketReservation\TicketReservationCommandHandler;
use Npl\Domain\Ticket\Application\TicketReservation\TicketReservator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Domain\Ticket\Application\TicketReservation\TicketReservationCommandHandler
 */
class TicketReservationCommandHandlerTest extends TestCase
{
    private MockObject $reservator;
    private TicketReservationCommandHandler $handler;

    /**
     * @covers \Npl\Domain\Shared\Core\ValueObject\IntValueObject::__construct
     */
    public function testInvoke()
    {
        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $command = static::createMock(TicketReservationCommand::class);
        $command
            ->expects(static::once())
            ->method('getLanId')
            ->willReturn(1);
        $command
            ->expects(static::once())
            ->method('getUserId')
            ->willReturn(2);
        $expectedLanId = new LanId(1);
        $expectedUserId = new UserId(2);
        $this->reservator
            ->expects(static::once())
            ->method('reserve')
            ->with($expectedLanId, $expectedUserId);
        $this->handler->__invoke($command);
    }

    protected function setUp(): void
    {
        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $this->reservator = static::createMock(TicketReservator::class);
        $this->handler = new TicketReservationCommandHandler($this->reservator);

        parent::setUp();
    }
}

