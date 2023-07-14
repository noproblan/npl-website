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

namespace Npl\LanOrganisation\Application\RemoveInfoFromLan;

use Npl\LanOrganisation\Application\LanDoesNotExistException;
use Npl\LanOrganisation\Application\Shared\LanInfoRequest;
use Npl\LanOrganisation\Application\Shared\LanInfosResponse;
use Npl\LanOrganisation\Domain\Model\Lan\LanInformation;
use Npl\LanOrganisation\Domain\Model\Lan\LanRepository;
use Npl\LanOrganisation\Domain\Service\Lan\LanIdFactory;

class RemoveInfoFromLanService
{
    public function __construct(
        private readonly LanIdFactory $lanIdFactory,
        private readonly LanRepository $lanRepository
    ) {
    }

    public function execute(LanInfoRequest $request): LanInfosResponse
    {
        $lanId = $this->lanIdFactory->fromString($request->getLanId());
        $lan = $this->lanRepository->ofId($lanId);

        if (!$lan) {
            throw new LanDoesNotExistException();
        }

        $title = $request->getTitle();
        $info = $request->getInfo();
        $newInfo = new LanInformation($title, $info);
        $lan->removeInfo($newInfo);
        $this->lanRepository->save($lan);

        return new LanInfosResponse($lan);
    }
}
