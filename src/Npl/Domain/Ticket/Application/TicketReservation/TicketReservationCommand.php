<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\TicketReservation;

use Npl\Domain\Shared\Core\Bus\Command\Command;

final class TicketReservationCommand implements Command
{
    public function __construct(private readonly int $lanId, private readonly int $userId)
    {
    }

    public function getLanId(): int
    {
        return $this->lanId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
