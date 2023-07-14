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

interface LanRepository
{
    public function nextIdentity(): LanId;
    public function ofId(LanId $anId): ?Lan;
    /**
     * @return Lan[]
     */
    public function getAll(): array;
    /**
     * @param LanSpecification $specification
     * @return Lan[]
     */
    public function query(LanSpecification $specification): array;
    public function save(Lan $lan): void;
    /**
     * @param Lan[] $lans
     * @return void
     */
    public function saveAll(array $lans): void;
    public function remove(Lan $aLan): void;
    /**
     * @param Lan[] $lans
     * @return void
     */
    public function removeAll(array $lans): void;
}
