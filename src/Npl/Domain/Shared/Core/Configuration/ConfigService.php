<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Configuration;

interface ConfigService
{
    public function getConfig($name);
}
