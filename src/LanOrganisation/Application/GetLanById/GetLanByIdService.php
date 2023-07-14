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

namespace Npl\LanOrganisation\Application\GetLanById;

use Npl\LanOrganisation\Application\LanDoesNotExistException;
use Npl\LanOrganisation\Application\LanResponse;
use Npl\LanOrganisation\Domain\Model\Lan\LanId;
use Npl\LanOrganisation\Domain\Model\Lan\LanRepository;

class GetLanByIdService
{
    public function __construct(private readonly LanRepository $repository)
    {
    }

    public function execute(GetLanByIdRequest $request): LanResponse
    {
        $requestId = $request->getLanId();
        $lanId = new LanId($requestId);
        $lan = $this->repository->ofId($lanId);

        if (!$lan) {
            throw new LanDoesNotExistException();
        }

        return new LanResponse($lan);
    }
}
