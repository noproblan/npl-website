<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\Ports;

use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Ticket\TicketId;
use Npl\Domain\Ticket\Core\Ticket;
use Npl\Domain\Ticket\Core\TicketCollection;

interface TicketRepository
{
    public function nextIdentity(): TicketId;

    public function loadById(TicketId $ticketId): ?Ticket;

    public function loadByCriteria(Criteria $criteria): TicketCollection;

    public function save(Ticket $ticket): void;
}
