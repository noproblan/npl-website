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

namespace Npl\LanOrganisation\Application;

use DateTimeInterface;
use JsonSerializable;
use Npl\LanOrganisation\Domain\Model\Lan\Lan;

class LanResponse implements JsonSerializable
{
    public function __construct(private readonly Lan $lan)
    {
    }

    public function jsonSerialize(): mixed
    {
        $infos = [];

        foreach ($this->lan->getInfos() as $info) {
            $infos[] = [
                'title' => $info->getTitle(),
                'info' => $info->getInfo()
            ];
        }

        return [
            'lanId' => $this->lan->getLanId()->getValue(),
            'name' => $this->lan->getName(),
            'startDatetime' => $this->lan->getStartDatetime()->format(DateTimeInterface::ATOM),
            'endDatetime' => $this->lan->getEndDatetime()->format(DateTimeInterface::ATOM),
            'infos' => $infos
        ];
    }
}
