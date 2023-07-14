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

use DateTimeImmutable;
use Npl\IAM\Application\HasPermission\HasPermissionRequest;
use Npl\IAM\Application\HasPermission\HasPermissionService;
use Npl\LanOrganisation\Domain\Model\Lan\Lan;
use Npl\LanOrganisation\Domain\Model\Lan\LanRepository;
use Npl\Shared\Application\NoPermissionException;
use Npl\Shared\Domain\Model\UserId;

class CreateLanService
{
    public function __construct(
        private readonly HasPermissionService $hasPermissionService,
        private readonly LanRepository $repository
    ) {
    }

    public function execute(CreateLanRequest $request): CreateLanResponse
    {
        $creatorId = UserId::fromString($request->getCreatorId());
        $permissionRequest = new HasPermissionRequest(
            $creatorId->getValue(),
            'create',
            'lan'
        );
        $hasPermission = $this->hasPermissionService->execute($permissionRequest)->hasPermission();

        if (!$hasPermission) {
            throw new NoPermissionException();
        }

        $lan = new Lan(
            $this->repository->nextIdentity(),
            new DateTimeImmutable($request->getStartDatetime()),
            new DateTimeImmutable($request->getEndDatetime()),
            []
        );

        $this->repository->save($lan);

        return new CreateLanResponse($lan);
    }
}
