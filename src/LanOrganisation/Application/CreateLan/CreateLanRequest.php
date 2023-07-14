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

class CreateLanRequest
{
    public function __construct(
        private readonly string $creatorId,
        private readonly string $name,
        private readonly string $startDatetime,
        private readonly string $endDatetime,
        private readonly int $plannedSeats
    ) {
    }

    /**
     * @return string
     */
    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStartDatetime(): string
    {
        return $this->startDatetime;
    }

    /**
     * @return string
     */
    public function getEndDatetime(): string
    {
        return $this->endDatetime;
    }

    /**
     * @return int
     */
    public function getPlannedSeats(): int
    {
        return $this->plannedSeats;
    }
}
