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

namespace Npl\Common\Domain\Model;

use Stringable;

class ValidationError
{
    public function __construct(private readonly string|Stringable $message)
    {
    }

    public function getMessage(): string
    {
        return (string) $this->message;
    }
}
