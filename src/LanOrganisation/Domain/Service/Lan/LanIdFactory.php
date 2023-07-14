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

namespace Npl\LanOrganisation\Domain\Service\Lan;

use Npl\LanOrganisation\Domain\Model\Lan\LanId;

class LanIdFactory
{
    public function create(): LanId
    {
        return new LanId();
    }

    public function fromString(string $lanId): LanId
    {
        return new LanId($lanId);
    }
}
