<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\TicketReservation;

use Npl\Domain\Shared\Core\Bus\Command\CommandHandler;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\User\UserId;

/**
 * @implements CommandHandler<TicketReservationCommand>
 */
final class TicketReservationCommandHandler implements CommandHandler
{
    public function __construct(private readonly TicketReservator $reservator)
    {
    }

    public function __invoke(mixed $command): void
    {
        $lanId = new LanId($command->getLanId());
        $userId = new UserId($command->getUserId());

        $this->reservator->reserve(
            $lanId,
            $userId
        );
    }
}
