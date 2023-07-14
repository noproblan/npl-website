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

use Npl\LanOrganisation\Domain\Model\Lan\LanId;
use Npl\LanOrganisation\Domain\Model\Ticket\Ticket;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketCreatorId;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketOwnerId;
use Npl\Shared\Domain\Model\TicketId;

class TicketFactory
{
    public function __construct(
        private readonly TicketIdFactory $idFactory,
        private readonly TicketOwningService $ticketOwningService
    ) {
    }

    public function create(LanId $lanId, TicketCreatorId $creatorId): Ticket
    {
        $ownerId = TicketOwnerId::fromString($creatorId->getValue());

        $this->ticketOwningService->validateNumberOfOwnedTickets($ownerId);

        return new Ticket(
            $this->idFactory->create(),
            $lanId,
            $creatorId,
            $ownerId
        );
    }

    public function fromExisting(
        TicketId $ticketId,
        LanId $lanId,
        TicketCreatorId $creatorId,
        TicketOwnerId $ownerId
    ): Ticket {
        return new Ticket(
            $ticketId,
            $lanId,
            $creatorId,
            $ownerId
        );
    }
}
