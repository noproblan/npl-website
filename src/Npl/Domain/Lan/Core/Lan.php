<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Core;

use Npl\Domain\Shared\Core\Lan\LanId;

final class Lan
{
    public function __construct(private readonly LanId $lanId, private readonly Name $lanName)
    {
    }

    public function getLanId(): LanId
    {
        return $this->lanId;
    }

    public function getLanName(): Name
    {
        return $this->lanName;
    }
}
