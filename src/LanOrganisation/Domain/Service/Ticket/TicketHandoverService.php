<?php

/*
 * This file is part of the noprobLAN Website.
 *
 * Copyright (c) 2023 Fabian Schweizer <fa.schweizer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Npl\LanOrganisation\Domain\Service\Ticket;

use Npl\LanOrganisation\Domain\Model\Ticket\Ticket;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketAlreadyOwnedException;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketOwnerId;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketRepository;

class TicketHandoverService
{
    public function __construct(
        private readonly TicketOwningService $owningService,
        private readonly TicketRepository $repository
    ) {
    }

    public function execute(Ticket $ticket, TicketOwnerId $newOwner): void
    {
        $currentOwner = $ticket->getOwnerId();

        if ($currentOwner->isEqualTo($newOwner)) {
            throw new TicketAlreadyOwnedException();
        }

        $this->owningService->validateNumberOfOwnedTickets($newOwner);

        $ticket->handTo($newOwner);
        $this->repository->save($ticket);
    }
}
