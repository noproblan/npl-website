<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\TicketReservation;

use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Criteria\FilterField;
use Npl\Domain\Shared\Core\Criteria\FilterOperator;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\FilterValue;
use Npl\Domain\Shared\Core\Criteria\Order;
use Npl\Domain\Shared\Core\Criteria\ValueFilter;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\User\UserId;
use Npl\Domain\Ticket\Application\Ports\TicketRepository;

final class TicketCounter
{
    public function __construct(private readonly TicketRepository $repository)
    {
    }

    public function count(LanId $lanId, UserId $userId): int
    {
        $filters = new Filters([
            new ValueFilter(
                new FilterField('lan_id'),
                FilterOperator::EQUAL,
                new FilterValue((string)$lanId->getValue())
            ),
            new ValueFilter(
                new FilterField('user_id'),
                FilterOperator::EQUAL,
                new FilterValue((string)$userId->getValue())
            ),
        ]);
        $criteria = new Criteria(
            $filters,
            Order::none(),
            null,
            null
        );
        $existingTickets = $this->repository->loadByCriteria($criteria);

        return $existingTickets->count();
    }
}
