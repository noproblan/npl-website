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

use Npl\IAM\Infrastructure\Persistence\MySQL\MySQLSpecification;
use Npl\LanOrganisation\Domain\Model\Ticket\Ticket;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketOwnerId;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketSpecification;

class MySQLTicketsByOwnerIdSpecification implements TicketSpecification, MySQLSpecification
{
    public function __construct(private readonly TicketOwnerId $ownerId)
    {
    }

    public function isSatisfiedBy(Ticket $ticket): bool
    {
        return $this->ownerId->isEqualTo($ticket->getOwnerId());
    }

    public function toSqlClauses(): string
    {
        return 'where `owner_id` = ' . $this->ownerId->getValue();
    }
}
