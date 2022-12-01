<?php

declare(strict_types=1);

namespace Npl\Domain\Ticket\Application\TicketReservation;

use InvalidArgumentException;
use Npl\Domain\Shared\Core\Configuration\ConfigService;
use Npl\Domain\Shared\Core\Lan\LanId;
use Npl\Domain\Shared\Core\User\UserId;

final class TicketHoardingPreventer
{
    public function __construct(
        private readonly ConfigService $configService,
        private readonly TicketCounter $counter
    ) {
    }

    public function preventHoarding(LanId $lanId, UserId $userId): void
    {
        $counted = $this->counter->count($lanId, $userId);
        $maxCount = (int) $this->configService->getConfig('maxAmountOfTicketsPerLanAndUser');

        if ($counted >= $maxCount) {
            throw new InvalidArgumentException(
                sprintf(
                    'User %s already has the maximum amount of %s tickets for lan %s.',
                    $userId->getValue(),
                    $maxCount,
                    $lanId->getValue()
                )
            );
        }
    }
}
