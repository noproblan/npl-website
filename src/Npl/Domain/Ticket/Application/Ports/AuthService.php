<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\Ports;

use Npl\Domain\Shared\Core\User\UserId;

interface AuthService
{
    public function getCurrentUserId(): UserId;

    public function checkPermission(string $resourceName): void;
}
