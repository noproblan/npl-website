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

namespace Npl\LanOrganisation\Domain\Model\Lan;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

class Lan
{
    private DateTimeImmutable $startDatetime;
    private DateTimeImmutable $endDatetime;

    /**
     * @param LanId $lanId
     * @param string $name
     * @param DateTimeImmutable $startDatetime
     * @param DateTimeImmutable $endDatetime
     * @param LanInformation[] $infos
     */
    public function __construct(
        private readonly LanId $lanId,
        private string $name,
        DateTimeImmutable $startDatetime,
        DateTimeImmutable $endDatetime,
        private array $infos
    ) {
        $this->setDatetimes($startDatetime, $endDatetime);
    }

    /**
     * @return LanId
     */
    public function getLanId(): LanId
    {
        return $this->lanId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartDatetime(): DateTimeImmutable
    {
        return $this->startDatetime;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndDatetime(): DateTimeImmutable
    {
        return $this->endDatetime;
    }

    /**
     * @return LanInformation[]
     */
    public function getInfos(): array
    {
        return $this->infos;
    }

    /**
     * @param string $name
     */
    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function addInfo(LanInformation $info): void
    {
        if (!in_array($info, $this->infos, true)) {
            $this->infos[] = $info;
        }
    }

    public function updateInfo(LanInformation $previousInfo, LanInformation $newInfo): void
    {
        if (in_array($previousInfo, $this->infos, true)) {
            $key = array_search($previousInfo, $this->infos, true);

            if (false !== $key) {
                $this->infos[$key] = $newInfo;
            }
        } else {
            $this->addInfo($newInfo);
        }
    }

    public function removeInfo(LanInformation $info): void
    {
        $key = array_search($info, $this->infos, true);

        if (false !== $key) {
            $offset = array_search($key, array_keys($this->infos), true);

            if (false !== $offset) {
                array_splice($this->infos, $offset, 1);
            }
        }
    }

    public function reorderInfos(array $infos): void
    {
        $difference = array_merge(array_diff($this->infos, $infos), array_diff($infos, $this->infos));

        if (count($difference) > 0) {
            throw new InvalidArgumentException('Infos not matching');
        }

        $this->infos = $infos;
    }

    private function setDatetimes(DateTimeImmutable $start, DateTimeImmutable $end): void
    {
        $this->assertValidDatetime($start);
        $this->assertValidDatetime($end);
        $this->assertEndDatetimeLaterThanStartDatetime($start, $end);
        $this->startDatetime = $start;
        $this->endDatetime = $end;
    }

    private function assertValidDatetime(DateTimeImmutable $datetime): void
    {
        if (
            $datetime->format(DateTimeInterface::ATOM) ===
            (new DateTimeImmutable(''))->format(DateTimeInterface::ATOM)
        ) {
            throw new InvalidArgumentException('Invalid datetime provided');
        }
    }

    private function assertEndDatetimeLaterThanStartDatetime(DateTimeImmutable $start, DateTimeImmutable $end): void
    {
        if ($start > $end) {
            throw new InvalidArgumentException('Start datetime after end datetime');
        }
    }
}
