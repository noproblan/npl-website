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

namespace Npl\LanOrganisation\Infrastructure\Domain\Service\Ticket;

use Npl\LanOrganisation\Domain\Model\Ticket\TicketOwnerId;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketSpecification;
use Npl\LanOrganisation\Domain\Service\Ticket\TicketSpecificationFactory;
use Npl\LanOrganisation\Infrastructure\Domain\Model\Ticket\MySQLTicketsByOwnerIdSpecification;

class MySQLTicketSpecificationFactory implements TicketSpecificationFactory
{
    public function createTicketsByOwnerId(TicketOwnerId $owner): TicketSpecification
    {
        return new MySQLTicketsByOwnerIdSpecification($owner);
    }
}
