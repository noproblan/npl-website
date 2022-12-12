<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core;

interface RandomNumberGenerator
{
    public function generate(): int;
}
