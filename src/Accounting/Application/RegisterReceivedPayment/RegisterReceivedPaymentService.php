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

namespace Npl\Accounting\Application\RegisterReceivedPayment;

use Npl\Domain\Shared\Core\Ticket\TicketId;

class RegisterReceivedPaymentService
{
    public function execute(RegisterReceivedPaymentRequest $request): RegisterReceivedPaymentResponse
    {
        $ticketId = new TicketId($request->getTicketId());
        $ticket = $this->ticketRepository->ofId($ticketId);

        if (!$ticket) {
            throw new TicketDoesNotExistException();
        }

        $amount = new Money($request->getPaymentAmount());
        $paymentReceivedDate = new \DateTimeImmutable($request->getPaymentDate());

        return new RegisterReceivedPaymentResponse(0);
    }
}
