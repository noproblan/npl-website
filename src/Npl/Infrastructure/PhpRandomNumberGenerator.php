<?php

declare(strict_types=1);

namespace Npl\Infrastructure;

use Exception;
use Npl\Domain\Shared\Core\RandomNumberGenerator;

final class PhpRandomNumberGenerator implements RandomNumberGenerator
{
    /**
     * @throws Exception
     */
    public function generate(): int
    {
        return random_int(1, 5);
    }
}
