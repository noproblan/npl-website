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

use Npl\LanOrganisation\Application\LanDoesNotExistException;
use Npl\LanOrganisation\Application\Shared\LanInfosResponse;
use Npl\LanOrganisation\Domain\Model\Lan\LanInformation;
use Npl\LanOrganisation\Domain\Model\Lan\LanRepository;
use Npl\LanOrganisation\Domain\Service\Lan\LanIdFactory;

class ReorderInfosOfLanService
{
    public function __construct(private readonly LanIdFactory $idFactory, private readonly LanRepository $repository)
    {
    }

    public function execute(ReorderInfosOfLanRequest $request): LanInfosResponse
    {
        $lanId = $this->idFactory->fromString($request->getLanId());
        $lan = $this->repository->ofId($lanId);

        if (!$lan) {
            throw new LanDoesNotExistException();
        }

        $reordered = [];

        foreach ($request->getLanInfos() as $title => $info) {
            $reordered[] = new LanInformation($title, $info);
        }

        $lan->reorderInfos($reordered);
        $this->repository->save($lan);

        return new LanInfosResponse($lan);
    }
}
