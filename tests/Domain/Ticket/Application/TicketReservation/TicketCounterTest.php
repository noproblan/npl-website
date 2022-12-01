<?php

declare(strict_types=1);

namespace Tests\Domain\Ticket\Application\TicketReservation;

use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\User\UserId;
use Npl\Domain\Ticket\Application\Ports\TicketRepository;
use Npl\Domain\Ticket\Application\TicketReservation\TicketCounter;
use Npl\Domain\Ticket\Core\TicketCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Domain\Ticket\Application\TicketReservation\TicketCounter
 */
class TicketCounterTest extends TestCase
{
    private MockObject $repository;
    private TicketCounter $counter;

    protected function setUp(): void
    {
        $this->repository = static::createMock(TicketRepository::class);
        $this->counter = new TicketCounter($this->repository);

        parent::setUp();
    }

    /**
     * @covers \Npl\Domain\Shared\Core\Collection::__construct
     * @covers \Npl\Domain\Shared\Core\Criteria\Criteria::__construct
     * @covers \Npl\Domain\Shared\Core\Criteria\Order::__construct
     * @covers \Npl\Domain\Shared\Core\Criteria\Order::none
     * @covers \Npl\Domain\Shared\Core\Criteria\ValueFilter::__construct
     * @covers \Npl\Domain\Shared\Core\ValueObject\StringValueObject::__construct
     */
    public function testCount()
    {
        $lanId = static::createStub(LanId::class);
        $userId = static::createStub(UserId::class);
        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $tickets = static::createMock(TicketCollection::class);
        $tickets
            ->expects(static::once())
            ->method('count')
            ->willReturn(2);
        $this->repository
            ->expects(static::once())
            ->method('loadByCriteria')
            ->willReturn($tickets);

        static::assertEquals(2, $this->counter->count($lanId, $userId));
    }
}

