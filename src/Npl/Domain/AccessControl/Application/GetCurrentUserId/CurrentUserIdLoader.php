<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\GetCurrentUserId;

use Npl\Domain\AccessControl\Core\Authentication\AuthenticationRepository;
use Npl\Domain\Shared\Core\User\UserId;

final class CurrentUserIdLoader
{
    public function __construct(private readonly AuthenticationRepository $repository)
    {
    }

    public function getCurrentUserId(): UserId
    {
        return $this->repository->loadCurrentUserId();
    }
}
