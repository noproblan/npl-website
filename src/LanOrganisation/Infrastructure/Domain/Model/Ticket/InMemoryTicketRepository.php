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

namespace Npl\LanOrganisation\Infrastructure\Domain\Model\Ticket;

use Npl\LanOrganisation\Domain\Model\Ticket\Ticket;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketRepository;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketSpecification;
use Npl\Shared\Domain\Model\TicketId;

class InMemoryTicketRepository implements TicketRepository
{
    /**
     * @var Ticket[]
     */
    private array $tickets = [];
    private int $counter = 0;

    public function nextIdentity(): TicketId
    {
        return new TicketId(++$this->counter);
    }

    public function ofId(TicketId $anId): ?Ticket
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->getTicketId()->isEqualTo($anId)) {
                return $ticket;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->tickets;
    }

    /**
     * @inheritDoc
     */
    public function query(TicketSpecification $specification): array
    {
        return array_filter($this->tickets, function ($item) use ($specification) {
            return $specification->isSatisfiedBy($item);
        });
    }

    public function save(Ticket $ticket): void
    {
        foreach ($this->tickets as $index => $existingTicket) {
            if ($existingTicket->getTicketId()->isEqualTo($ticket->getTicketId())) {
                $this->tickets[$index] = $ticket;
                return;
            }
        }

        $this->tickets[] = $ticket;
    }

    /**
     * @inheritDoc
     */
    public function saveAll(array $tickets): void
    {
        foreach ($tickets as $ticket) {
            $this->save($ticket);
        }
    }

    public function remove(Ticket $aTicket): void
    {
        $this->tickets = array_filter($this->tickets, static function ($element) use ($aTicket) {
            return !$element->getTicketId()->isEqualTo($aTicket->getTicketId());
        });
    }

    /**
     * @inheritDoc
     */
    public function removeAll(array $tickets): void
    {
        foreach ($tickets as $ticket) {
            $this->remove($ticket);
        }
    }
}
