<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Core;

use Npl\Domain\Shared\Core\Collection;

/**
 * @extends Collection<Ticket>
 */
final class TicketCollection extends Collection
{
    public function getTickets(): array
    {
        return $this->getItems();
    }

    protected function getCollectionType(): string
    {
        return Ticket::class;
    }
}
