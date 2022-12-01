<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Application\IsPermitted;

use Npl\Domain\Shared\Core\Bus\Query\Response;

final class IsPermittedResponse implements Response
{
    public function __construct(private readonly bool $isPermitted)
    {
    }

    public function isPermitted(): bool
    {
        return $this->isPermitted;
    }
}
