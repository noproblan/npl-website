<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\Ports;

use Npl\Domain\Shared\Core\User\UserId;

interface UserService
{
    public function isActive(UserId $userId): bool;
}
