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

namespace Npl\IAM\Infrastructure\Domain\Model\Email;

use Npl\IAM\Domain\Model\Email\Email;
use Npl\IAM\Domain\Model\Email\EmailFactory;

class SymfonyValidatedEmailFactory implements EmailFactory
{
    public function __construct(private readonly SymfonyEmailValidator $validator)
    {
    }

    public function fromString(string $email): Email
    {
        return new Email($this->validator, $email);
    }
}
