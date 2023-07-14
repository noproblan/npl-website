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

class RegisterReceivedPaymentRequest
{
    public function __construct(
        private readonly int $ticketId,
        private readonly string $paymentDate,
        private readonly int $paymentAmount
    ) {
    }

    public function getTicketId(): int
    {
        return $this->ticketId;
    }

    public function getPaymentDate(): string
    {
        return $this->paymentDate;
    }

    public function getPaymentAmount(): int
    {
        return $this->paymentAmount;
    }
}
