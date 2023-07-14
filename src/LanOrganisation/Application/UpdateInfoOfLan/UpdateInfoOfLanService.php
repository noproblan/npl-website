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

namespace Npl\LanOrganisation\Application\UpdateInfoOfLan;

use Npl\LanOrganisation\Application\LanDoesNotExistException;
use Npl\LanOrganisation\Application\Shared\LanInfosResponse;
use Npl\LanOrganisation\Domain\Model\Lan\LanInformation;
use Npl\LanOrganisation\Domain\Model\Lan\LanRepository;
use Npl\LanOrganisation\Domain\Service\Lan\LanIdFactory;

class UpdateInfoOfLanService
{
    public function __construct(
        private readonly LanIdFactory $lanIdFactory,
        private readonly LanRepository $lanRepository
    ) {
    }

    public function execute(UpdateInfoOfLanRequest $request): LanInfosResponse
    {
        $lanId = $this->lanIdFactory->fromString($request->getLanId());
        $lan = $this->lanRepository->ofId($lanId);

        if (!$lan) {
            throw new LanDoesNotExistException();
        }

        $previousInfo = new LanInformation($request->getPreviousTitle(), $request->getPreviousInfo());
        $newInfo = new LanInformation($request->getNewTitle(), $request->getNewInfo());
        $lan->updateInfo($previousInfo, $newInfo);
        $this->lanRepository->save($lan);

        return new LanInfosResponse($lan);
    }
}
