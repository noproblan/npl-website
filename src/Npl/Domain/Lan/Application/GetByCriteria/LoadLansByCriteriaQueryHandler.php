<?php

declare(strict_types=1);

namespace Npl\Domain\Lan\Application\GetByCriteria;

use Npl\Domain\Lan\Application\LansResponse;
use Npl\Domain\Shared\Core\Bus\Query\QueryHandler;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\Order;

/**
 * @implements QueryHandler<LoadLansByCriteriaQuery, LansResponse>
 */
final class LoadLansByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(private readonly LansByCriteriaLoader $loader)
    {
    }

    public function __invoke(mixed $query): LansResponse
    {
        $filters = Filters::fromValues($query->getFilters());
        $order = Order::fromValues(
            $query->getOrderBy(),
            $query->getOrder()
        );

        return $this->loader->load(
            $filters,
            $order,
            $query->getOffset(),
            $query->getLimit()
        );
    }
}
