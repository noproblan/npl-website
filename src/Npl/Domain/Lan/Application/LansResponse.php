<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Application;

use Npl\Domain\Shared\Core\Bus\Query\Response;

final class LansResponse implements Response
{
    /**
     * @var LanResponse[]
     */
    private readonly array $lans;

    public function __construct(LanResponse ...$lans)
    {
        $this->lans = $lans;
    }

    public function getLans(): array
    {
        return $this->lans;
    }
}
