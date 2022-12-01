<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core\Authentication;

use Npl\Domain\Shared\Core\User\UserId;

interface AuthenticationRepository
{
    public function loadCurrentUserId(): UserId;
}
