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

namespace Npl\LanOrganisation\Application\ReserveTicket;

use Npl\IAM\Application\HasPermission\HasPermissionRequest;
use Npl\IAM\Application\HasPermission\HasPermissionService;
use Npl\LanOrganisation\Application\LanDoesNotExistException;
use Npl\LanOrganisation\Domain\Model\Lan\LanId;
use Npl\LanOrganisation\Domain\Model\Lan\LanRepository;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketCreatorId;
use Npl\LanOrganisation\Domain\Model\Ticket\TicketRepository;
use Npl\LanOrganisation\Domain\Service\Ticket\TicketFactory;
use Npl\Shared\Application\NoPermissionException;

class ReserveTicketService
{
    public function __construct(
        private readonly HasPermissionService $hasPermissionService,
        private readonly LanRepository $lanRepository,
        private readonly TicketFactory $ticketFactory,
        private readonly TicketRepository $ticketRepository
    ) {
    }

    public function execute(ReserveTicketRequest $request): ReserveTicketResponse
    {
        $creatorId = TicketCreatorId::fromString($request->getCreatorId());

        $permissionRequest = new HasPermissionRequest(
            $creatorId->getValue(),
            'reserve',
            'Ticket'
        );
        $hasPermission = $this->hasPermissionService->execute($permissionRequest)->hasPermission();

        if (!$hasPermission) {
            throw new NoPermissionException();
        }

        $lanId = new LanId($request->getLanId());
        $lan = $this->lanRepository->ofId($lanId);

        if (!$lan) {
            throw new LanDoesNotExistException();
        }

        $ticket = $this->ticketFactory->create($lanId, $creatorId);
        $this->ticketRepository->save($ticket);

        return new ReserveTicketResponse($ticket);
    }
}
