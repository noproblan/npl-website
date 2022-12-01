<?php

declare(strict_types=1);

namespace Tests\Domain\Ticket\Application\TicketReservation;

use Exception;
use InvalidArgumentException;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\Ticket\TicketId;
use Npl\Domain\Shared\Core\User\UserId;
use Npl\Domain\Ticket\Application\Ports\AuthService;
use Npl\Domain\Ticket\Application\Ports\LanService;
use Npl\Domain\Ticket\Application\Ports\TicketRepository;
use Npl\Domain\Ticket\Application\Ports\UserService;
use Npl\Domain\Ticket\Application\TicketReservation\TicketHoardingPreventer;
use Npl\Domain\Ticket\Application\TicketReservation\TicketReservator;
use Npl\Domain\Ticket\Core\Ticket;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Npl\Domain\Ticket\Application\TicketReservation\TicketReservator
 * @covers \Npl\Domain\Shared\Core\ValueObject\IntValueObject::__construct
 */
class TicketReservatorTest extends TestCase
{
    private MockObject $authService;
    private Stub $lanService;
    private Stub $userService;
    private Stub $preventer;
    private MockObject $repository;
    private TicketReservator $ticketReservator;

    public function testReserveCallsAuthServiceWithReserveTicketPermission()
    {
        static::expectException(Exception::class);
        $this->authService
            ->expects(static::once())
            ->method('checkPermission')
            ->with(static::equalTo('reserveTicket'))
            ->willThrowException(new Exception('Some exception within'));
        $this->ticketReservator->reserve(new LanId(1), new UserId(1));
    }

    public function testReserveThrowsInvalidLanIdProvided()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid lan id provided.');
        $this->lanService->method('exists')->willReturn(false);
        $this->ticketReservator->reserve(new LanId(1), new UserId(1));
    }

    public function testReserveThrowsInvalidUserIdProvided()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid user id provided.');
        $this->lanService->method('exists')->willReturn(true);
        $this->userService->method('isActive')->willReturn(false);
        $this->ticketReservator->reserve(new LanId(1), new UserId(1));
    }

    /**
     * @covers \Npl\Domain\Shared\Core\ValueObject\IntValueObject::getValue
     */
    public function testReserveThrowsLanNotOpenForRegistration()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tickets can\'t be reserved for lan 1.');
        $this->lanService->method('exists')->willReturn(true);
        $this->userService->method('isActive')->willReturn(true);
        $this->lanService->method('isOpenForRegistration')->willReturn(false);
        $this->ticketReservator->reserve(new LanId(1), new UserId(1));
    }

    public function testReserveCallsPreventer()
    {
        static::expectException(Exception::class);
        $this->lanService->method('exists')->willReturn(true);
        $this->userService->method('isActive')->willReturn(true);
        $this->lanService->method('isOpenForRegistration')->willReturn(true);
        $this->preventer
            ->expects(static::once())
            ->method('preventHoarding')
            ->with(static::equalTo(new LanId(1)), static::equalTo(new UserId(1)))
            ->willThrowException(new Exception());
        $this->ticketReservator->reserve(new LanId(1), new UserId(1));
    }

    /**
     * @covers \Npl\Domain\Shared\Core\ValueObject\IntValueObject::getValue
     * @covers \Npl\Domain\Shared\Core\ValueObject\IntValueObject::isEqual
     */
    public function testReserveCallsCheckPermissionWhenCurrentUserNotEqual()
    {
        static::expectException(Exception::class);
        $matcher = static::exactly(2);
        $this->authService
            ->expects(static::once())
            ->method('getCurrentUserId')
            ->willReturn(new UserId(1));
        $this->authService
            ->expects($matcher)
            ->method('checkPermission')
            ->withConsecutive(
                ['reserveTicket'],
                ['reserveTicketForOthers']
            )
            ->willReturnCallback(function () use ($matcher) {
                if ($matcher->getInvocationCount() > 1) {
                    throw new Exception('Some exception within');
                }
            });
        $this->lanService->method('exists')->willReturn(true);
        $this->userService->method('isActive')->willReturn(true);
        $this->lanService->method('isOpenForRegistration')->willReturn(true);
        $this->ticketReservator->reserve(new LanId(1), new UserId(2));
    }

    /**
     * @covers \Npl\Domain\Ticket\Core\Ticket::__construct
     * @covers \Npl\Domain\Ticket\Core\Ticket::create
     * @covers \Npl\Domain\Ticket\Core\TicketExtras::__construct
     */
    public function testReserve(): void
    {
        $ticketId = static::createStub(TicketId::class);
        $this->repository
            ->expects(static::once())
            ->method('nextIdentity')
            ->willReturn($ticketId);
        $this->repository
            ->expects(static::once())
            ->method('save')
            ->with(Ticket::create($ticketId, new LanId(1), new UserId(1)));
        $this->lanService->method('exists')->willReturn(true);
        $this->userService->method('isActive')->willReturn(true);
        $this->lanService->method('isOpenForRegistration')->willReturn(true);
        $this->ticketReservator->reserve(new LanId(1), new UserId(1));
    }

    protected function setUp(): void
    {
        $this->authService = $this->createMock(AuthService::class);
        $this->lanService = $this->createStub(LanService::class);
        $this->userService = $this->createStub(UserService::class);
        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $this->preventer = $this->createMock(TicketHoardingPreventer::class);
        $this->repository = $this->createMock(TicketRepository::class);
        $this->ticketReservator = new TicketReservator(
            $this->authService,
            $this->lanService,
            $this->userService,
            $this->preventer,
            $this->repository
        );
        parent::setUp();
    }
}

