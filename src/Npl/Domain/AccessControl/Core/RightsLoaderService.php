<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core;

use Npl\Domain\AccessControl\Core\Authorization\Resource\ResourceName;
use Npl\Domain\AccessControl\Core\Authorization\Right\Rights;

interface RightsLoaderService
{
    public function load(ResourceName $resourceName): Rights;
}
