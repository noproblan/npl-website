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

use Npl\LanOrganisation\Domain\Model\Ticket\TicketSpecification;
use Npl\Shared\Domain\Model\TicketId;

interface TicketRepository
{
    public function nextIdentity(): TicketId;
    public function ofId(TicketId $anId): ?Ticket;
    /**
     * @return Ticket[]
     */
    public function getAll(): array;
    /**
     * @param TicketSpecification $specification
     * @return Ticket[]
     */
    public function query(TicketSpecification $specification): array;
    public function save(Ticket $ticket): void;
    /**
     * @param Ticket[] $tickets
     * @return void
     */
    public function saveAll(array $tickets): void;
    public function remove(Ticket $aTicket): void;
    /**
     * @param Ticket[] $tickets
     * @return void
     */
    public function removeAll(array $tickets): void;
}
