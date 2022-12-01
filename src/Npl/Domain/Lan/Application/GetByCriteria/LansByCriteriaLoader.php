<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Application\GetByCriteria;

use Npl\Domain\Lan\Application\LanResponse;
use Npl\Domain\Lan\Application\LansResponse;
use Npl\Domain\Lan\Core\Lan;
use Npl\Domain\Lan\Core\LanRepository;
use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\Order;

final class LansByCriteriaLoader
{
    public function __construct(private readonly LanRepository $repository)
    {
    }

    public function load(Filters $filters, Order $order, ?int $offset, ?int $limit): LansResponse
    {
        $criteria = new Criteria(
            $filters,
            $order,
            $offset,
            $limit
        );

        $lans = $this->repository->loadByCriteria($criteria);
        /** @var LanResponse[] $lanResponses */
        $lanResponses = array_map($this->toResponse(), $lans->getLans());

        return new LansResponse(...$lanResponses);
    }

    private function toResponse(): callable
    {
        return static fn(Lan $lan) => new LanResponse(
            $lan->getLanId()->getValue(),
            $lan->getLanName()->getValue()
        );
    }
}
