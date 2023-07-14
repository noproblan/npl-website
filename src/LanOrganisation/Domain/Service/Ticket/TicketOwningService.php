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

use Npl\LanOrganisation\Domain\Model\Ticket\TicketOwnerId;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketRepository;
use Npl\LanOrganisation\Domain\Model\Ticket\UserHasAlreadyEnoughTicketsException;

class TicketOwningService
{
    private const MAX_TICKETS = 1;

    public function __construct(
        private readonly TicketRepository $ticketRepository,
        private readonly TicketSpecificationFactory $specFactory
    ) {
    }

    public function validateNumberOfOwnedTickets(TicketOwnerId $ownerId): void
    {
        $spec = $this->specFactory->createTicketsByOwnerId($ownerId);
        $tickets = $this->ticketRepository->query($spec);

        if (count($tickets) > self::MAX_TICKETS) {
            throw new UserHasAlreadyEnoughTicketsException();
        }
    }
}
