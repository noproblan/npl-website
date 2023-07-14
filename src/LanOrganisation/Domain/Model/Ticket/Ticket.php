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

namespace Npl\LanOrganisation\Domain\Model\Ticket;

use Npl\LanOrganisation\Domain\Model\Lan\LanId;
use Npl\Shared\Domain\Model\TicketId;

class Ticket
{
    public function __construct(
        private readonly TicketId $ticketId,
        private readonly LanId $lanId,
        private readonly TicketCreatorId $creatorId,
        private TicketOwnerId $ownerId
    ) {
    }

    public function getTicketId(): TicketId
    {
        return $this->ticketId;
    }

    public function getLanId(): LanId
    {
        return $this->lanId;
    }

    public function getCreatorId(): TicketCreatorId
    {
        return $this->creatorId;
    }

    public function getOwnerId(): TicketOwnerId
    {
        return $this->ownerId;
    }

    public function handTo(TicketOwnerId $newOwnerId): void
    {
        if (!$this->ownerId->isEqualTo($newOwnerId)) {
            $this->ownerId = $newOwnerId;
        }
    }
}
