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

namespace Npl\LanOrganisation\Infrastructure\Domain\Model\Lan;

use Npl\LanOrganisation\Domain\Model\Lan\Lan;
use Npl\LanOrganisation\Domain\Model\Lan\LanId;
use Npl\LanOrganisation\Domain\Model\Lan\LanRepository;
use Npl\LanOrganisation\Domain\Model\Lan\LanSpecification;

class InMemoryLanRepository implements LanRepository
{
    /**
     * @var Lan[]
     */
    private array $lans = [];

    public function __construct()
    {
        $this->lans[] = new Lan(
            new LanId('320fef52-a8e8-4849-900b-1ada34cd4a53'),
            'Example Lan',
            new \DateTimeImmutable('-1 days'),
            new \DateTimeImmutable('+1 days'),
            []
        );
    }

    public function nextIdentity(): LanId
    {
        return new LanId();
    }

    public function ofId(LanId $anId): ?Lan
    {
        foreach ($this->lans as $lan) {
            if ($lan->getLanId()->isEqualTo($anId)) {
                return $lan;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->lans;
    }

    /**
     * @inheritDoc
     */
    public function query(LanSpecification $specification): array
    {
        return array_filter($this->lans, function ($item) use ($specification) {
            return $specification->isSatisfiedBy($item);
        });
    }

    /**
     * @inheritDoc
     */
    public function saveAll(array $lans): void
    {
        foreach ($lans as $lan) {
            $this->save($lan);
        }
    }

    public function save(Lan $lan): void
    {
        foreach ($this->lans as $index => $existingLan) {
            if ($existingLan->getLanId()->isEqualTo($lan->getLanId())) {
                $this->lans[$index] = $lan;
                return;
            }
        }

        $this->lans[] = $lan;
    }

    /**
     * @inheritDoc
     */
    public function removeAll(array $lans): void
    {
        foreach ($lans as $lan) {
            $this->remove($lan);
        }
    }

    public function remove(Lan $aLan): void
    {
        $this->lans = array_filter($this->lans, static function ($element) use ($aLan) {
            return !$element->getLanId()->isEqualTo($aLan->getLanId());
        });
    }
}
