<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Application;

use Npl\Domain\Shared\Core\Bus\Query\Response;

final class LanResponse implements Response
{
    public function __construct(private readonly int $lanId, private readonly string $name)
    {
    }

    public function getLanId(): int
    {
        return $this->lanId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
