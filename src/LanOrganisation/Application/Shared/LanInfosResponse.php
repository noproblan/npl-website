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

namespace Npl\LanOrganisation\Application\Shared;

use Npl\LanOrganisation\Domain\Model\Lan\Lan;

class LanInfosResponse
{
    private string $infos;

    public function __construct(Lan $lan)
    {
        $this->infos = json_encode($lan->getInfos());
    }

    public function getInfos(): string
    {
        return $this->infos;
    }
}
