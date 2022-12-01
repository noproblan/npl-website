<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\Ports;

use Npl\Domain\Shared\Core\Lan\LanId;

interface LanService
{
    public function exists(LanId $lanId): bool;

    public function isOpenForRegistration(LanId $lanId): bool;
}
