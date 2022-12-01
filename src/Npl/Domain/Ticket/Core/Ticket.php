<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

use InvalidArgumentException;
use Npl\Domain\Shared\Core\Aggregate\AggregateRoot;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\Seat\SeatId;
use Npl\Domain\Shared\Core\Ticket\TicketId;
use Npl\Domain\Shared\Core\User\UserId;

final class Ticket extends AggregateRoot
{
    public function __construct(
        private readonly TicketId $ticketId,
        private readonly LanId $lanId,
        private UserId $userId,
        private ?SeatId $seatId,
        private TicketExtras $extras,
        private TicketStatus $status,
        private bool $isHelper,
    ) {
    }

    public static function create(TicketId $ticketId, LanId $lanId, UserId $userId): self
    {
        return new self(
            $ticketId,
            $lanId,
            $userId,
            null,
            new TicketExtras([]),
            TicketStatus::NOT_PAID,
            false
        );
    }

    public function updateOwner(UserId $newOwnerId): void
    {
        $this->userId = $newOwnerId;
    }

    public function updateSeat(?SeatId $newSeatId): void
    {
        $this->seatId = $newSeatId;
    }

    public function updateExtras(TicketExtras $newExtras): void
    {
        $this->extras = $newExtras;
    }

    public function markPrepaid(): void
    {
        if ($this->status->isInPaidState()) {
            throw new InvalidArgumentException(
                sprintf(
                    'Ticket %s is already marked as paid',
                    $this->ticketId->getValue()
                )
            );
        }

        $this->status = TicketStatus::PREPAID;
    }

    public function markPaid(): void
    {
        if ($this->status->isInPaidState()) {
            throw new InvalidArgumentException(
                sprintf(
                    'Ticket %s is already marked as paid',
                    $this->ticketId->getValue()
                )
            );
        }

        $this->status = TicketStatus::PAID;
    }

    public function markUnpaid(): void
    {
        if (!$this->status->isInPaidState()) {
            throw new InvalidArgumentException(
                sprintf(
                    'Ticket %s is already marked as not paid',
                    $this->ticketId->getValue()
                )
            );
        }

        $this->status = TicketStatus::NOT_PAID;
    }

    public function markAsHelperTicket(): void
    {
        $this->isHelper = true;
    }

    public function markAsRegularTicket(): void
    {
        $this->isHelper = false;
    }

    public function getTicketId(): TicketId
    {
        return $this->ticketId;
    }

    public function getLanId(): LanId
    {
        return $this->lanId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getSeatId(): ?SeatId
    {
        return $this->seatId;
    }

    public function getExtras(): TicketExtras
    {
        return $this->extras;
    }

    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    public function isHelper(): bool
    {
        return $this->isHelper;
    }
}
