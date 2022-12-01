<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core;

interface PermissionChecker
{
    /**
     * @param string $resourceName
     * @return bool
     */
    public function check(string $resourceName): bool;
}
