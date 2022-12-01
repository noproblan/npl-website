<?php

declare(strict_types=1);

namespace Tests\Domain\Ticket\Application\TicketReservation;

use InvalidArgumentException;
use Npl\Domain\Shared\Core\Configuration\ConfigService;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\User\UserId;
use Npl\Domain\Ticket\Application\TicketReservation\TicketCounter;
use Npl\Domain\Ticket\Application\TicketReservation\TicketHoardingPreventer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Domain\Ticket\Application\TicketReservation\TicketHoardingPreventer
 */
class TicketHoardingPreventerTest extends TestCase
{
    private MockObject $configService;
    private MockObject $counter;
    private TicketHoardingPreventer $preventer;

    public function testPreventHoardingThrowsWhenMaxTicketsReached()
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('User 1 already has the maximum amount of 3 tickets for lan 1.');
        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $lanId = static::createMock(LanId::class);
        $lanId
            ->expects(static::once())
            ->method('getValue')
            ->willReturn(1);
        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $userId = static::createMock(UserId::class);
        $userId
            ->expects(static::once())
            ->method('getValue')
            ->willReturn(1);
        $this->counter
            ->expects(static::once())
            ->method('count')
            ->willReturn(3);
        $this->configService
            ->expects(static::once())
            ->method('getConfig')
            ->willReturn('3');
        $this->preventer->preventHoarding($lanId, $userId);
    }

    public function testPreventHoarding()
    {
        $lanId = static::createStub(LanId::class);
        $userId = static::createStub(UserId::class);
        $this->counter
            ->expects(static::once())
            ->method('count')
            ->willReturn(3);
        $this->configService
            ->expects(static::once())
            ->method('getConfig')
            ->willReturn('5');
        $this->preventer->preventHoarding($lanId, $userId);
    }

    protected function setUp(): void
    {
        $this->configService = static::createMock(ConfigService::class);
        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $this->counter = static::createMock(TicketCounter::class);
        $this->preventer = new TicketHoardingPreventer(
            $this->configService,
            $this->counter
        );

        parent::setUp();
    }
}

