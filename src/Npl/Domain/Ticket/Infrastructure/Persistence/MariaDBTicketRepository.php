<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Infrastructure\Persistence;

use Aura\SqlQuery\Mysql\Insert;
use Exception;
use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\Seat\SeatId;
use Npl\Domain\Shared\Core\Ticket\TicketId;
use Npl\Domain\Shared\Core\User\UserId;
use Npl\Domain\Ticket\Application\Ports\TicketRepository;
use Npl\Domain\Ticket\Core\ExtraFactory;
use Npl\Domain\Ticket\Core\Ticket;
use Npl\Domain\Ticket\Core\TicketExtras;
use Npl\Domain\Ticket\Core\TicketCollection;
use Npl\Domain\Ticket\Core\TicketStatus;
use Npl\Infrastructure\Persistence\MariaDBCriteriaConverter;
use Npl\Infrastructure\Persistence\MariaDBRepository;

final class MariaDBTicketRepository extends MariaDBRepository implements TicketRepository
{
    public function nextIdentity(): TicketId
    {
        return TicketId::v1();
    }

    public function loadById(TicketId $ticketId): ?Ticket
    {
        $ticket = null;

        $select = $this->factory->newSelect()
            ->from('npl_srs_tickets')
            ->where('id = :id')
            ->bindValue('id', $ticketId->getValue());

        $sql = $select->getStatement();
        $parameters = $select->getBindValues();
        $statement = $this->execute($sql, $parameters);

        if ($statement) {
            $row = $statement->fetch();

            if ($row) {
                $ticket = $this->createTicketFromRow($row);
            }
        }

        return $ticket;
    }

    /**
     * @param non-empty-array<string, null|scalar> $row
     * @return Ticket
     */
    private function createTicketFromRow(array $row): Ticket
    {
        $ticketId = new TicketId((string)$row['id']);
        $lanId = new LanId((int)$row['lan_id']);
        $userId = new UserId((int)$row['user_id']);
        $seatId = is_null($row['seat_id']) ? null : new SeatId((int)$row['seat_id']);
        $extras = explode(',', (string)$row['extras']);
        $concreteExtras = [];
        foreach ($extras as $extra) {
            try {
                $concreteExtras[] = ExtraFactory::from($extra);
            } catch (Exception) {
                // TODO: Maybe log this?
            }
        }
        $ticketExtras = new TicketExtras($concreteExtras);
        $ticketStatus = TicketStatus::from((string)$row['status']);
        $isHelper = (bool)$row['is_helper'];

        return new Ticket(
            $ticketId,
            $lanId,
            $userId,
            $seatId,
            $ticketExtras,
            $ticketStatus,
            $isHelper
        );
    }

    public function loadByCriteria(Criteria $criteria): TicketCollection
    {
        /** @var Ticket[] $tickets */
        $tickets = [];

        $select = $this->factory->newSelect()
            ->from('npl_srs_tickets')
            ->cols(['*']);
        $select = MariaDBCriteriaConverter::create($select, $criteria)->getRestrictedSelect();

        $sql = $select->getStatement();
        $parameters = $select->getBindValues();
        $statement = $this->execute($sql, $parameters);

        if ($statement) {
            $rows = $statement->fetchAll();

            if ($rows) {
                foreach ($rows as $row) {
                    /** @var non-empty-array<string, null|scalar> $row */
                    $tickets[] = $this->createTicketFromRow($row);
                }
            }
        }

        return new TicketCollection($tickets);
    }

    public function save(Ticket $ticket): void
    {
        /** @var Insert $insert */
        $insert = $this->factory->newInsert()
            ->orReplace()
            ->into('npl_srs_tickets')
            ->cols([
                'id' => $ticket->getTicketId(),
                'lan_id' => $ticket->getLanId(),
                'user_id' => $ticket->getUserId(),
            ]);
        // TODO: Implement save() method.
        $sql = $insert->getStatement();
        $statement = $this->execute($sql);
    }
}
