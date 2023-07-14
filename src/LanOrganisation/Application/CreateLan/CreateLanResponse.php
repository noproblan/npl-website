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

namespace Npl\LanOrganisation\Application\CreateLan;

use Npl\LanOrganisation\Domain\Model\Lan\Lan;

class CreateLanResponse
{
    private string $lanId;

    public function __construct(Lan $lan)
    {
        $this->lanId = $lan->getLanId()->getValue();
    }

    /**
     * @return string
     */
    public function getLanId(): string
    {
        return $this->lanId;
    }
}
