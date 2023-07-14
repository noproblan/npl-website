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

namespace Npl\LanOrganisation\Application\ReorderInfosOfLan;

use InvalidArgumentException;

class ReorderInfosOfLanRequest
{
    /**
     * @var array<string, string>
     */
    private array $infos;

    public function __construct(
        private readonly string $lanId,
        readonly string $lanInfos
    ) {
        $decoded = json_decode($lanInfos, true);

        if (!is_array($decoded)) {
            throw new InvalidArgumentException('No list of infos provided');
        }

        // We keep only strings as other values are not lan infos
        /** @var string[] $infos */
        $infos = [];
        /**
         * @var string|int $key
         * @var mixed $value
         */
        foreach ($decoded as $key => $value) {
            if (is_string($key) && is_string($value)) {
                $infos[$key] = $value;
            }
        }

        $this->infos = $infos;
    }

    public function getLanId(): string
    {
        return $this->lanId;
    }

    /**
     * @return array<string, string>
     */
    public function getLanInfos(): array
    {
        return $this->infos;
    }
}
