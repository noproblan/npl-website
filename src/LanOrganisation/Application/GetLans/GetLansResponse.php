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

namespace Npl\LanOrganisation\Application\GetLans;

use Npl\LanOrganisation\Application\LanResponse;
use Npl\LanOrganisation\Domain\Model\Lan\Lan;

class GetLansResponse
{
    /**
     * @var LanResponse[]
     */
    private array $lans = [];

    /**
     * @param Lan[] $lans
     */
    public function __construct(array $lans)
    {
        foreach ($lans as $lan) {
            $this->lans[] = new LanResponse($lan);
        }
    }

    /**
     * @return LanResponse[]
     */
    public function getLans(): array
    {
        return $this->lans;
    }
}
