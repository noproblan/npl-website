<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\TicketReservation;

use InvalidArgumentException;
use Npl\Domain\Ticket\Application\Ports\AuthService;
use Npl\Domain\Ticket\Application\Ports\LanService;
use Npl\Domain\Ticket\Application\Ports\TicketRepository;
use Npl\Domain\Ticket\Application\Ports\UserService;
use Npl\Domain\Ticket\Core\Ticket;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\User\UserId;

final class TicketReservator
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly LanService $lanService,
        private readonly UserService $userService,
        private readonly TicketHoardingPreventer $preventer,
        private readonly TicketRepository $repository
    ) {
    }

    public function reserve(LanId $lanId, UserId $userId): void
    {
        $this->ensureAccessControl();
        $this->ensureLanExists($lanId);
        $this->ensureUserIsActive($userId);
        $this->ensureLanIsOpenForRegistration($lanId);
        $this->ensureNonHoarding(
            $lanId,
            $userId
        );
        $this->ensureCurrentUserCanReserveTicketForUser($userId);

        $this->reserveTicket(
            $lanId,
            $userId
        );
    }

    private function ensureAccessControl(): void
    {
        $this->authService->checkPermission('reserveTicket');
    }

    private function ensureLanExists(LanId $lanId): void
    {
        $exists = $this->lanService->exists($lanId);

        if (!$exists) {
            throw new InvalidArgumentException('Invalid lan id provided.');
        }
    }

    private function ensureUserIsActive(UserId $userId): void
    {
        $isActive = $this->userService->isActive($userId);

        if (!$isActive) {
            throw new InvalidArgumentException('Invalid user id provided.');
        }
    }

    private function ensureLanIsOpenForRegistration(LanId $lanId): void
    {
        $isOpen = $this->lanService->isOpenForRegistration($lanId);

        if (!$isOpen) {
            throw new InvalidArgumentException(
                sprintf(
                    'Tickets can\'t be reserved for lan %s.',
                    $lanId->getValue()
                )
            );
        }
    }

    private function ensureNonHoarding(LanId $lanId, UserId $userId): void
    {
        $this->preventer->preventHoarding($lanId, $userId);
    }

    private function ensureCurrentUserCanReserveTicketForUser(UserId $userId): void
    {
        $currentUserId = $this->authService->getCurrentUserId();

        if (!$currentUserId->isEqual($userId)) {
            $this->authService->checkPermission('reserveTicketForOthers');
        }
    }

    private function reserveTicket(LanId $lanId, UserId $userId): void
    {
        $ticketId = $this->repository->nextIdentity();
        $ticket = Ticket::create($ticketId, $lanId, $userId);
        $this->repository->save($ticket);
    }
}
