<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core;

use Exception;
use Npl\Domain\AccessControl\Application\Ports\ResourceRepository;
use Npl\Domain\AccessControl\Application\Ports\RightRepository;
use Npl\Domain\AccessControl\Core\Authorization\Resource\ResourceName;
use Npl\Domain\AccessControl\Core\Authorization\Right\Rights;
use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Criteria\FilterField;
use Npl\Domain\Shared\Core\Criteria\FilterOperator;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\FilterValue;
use Npl\Domain\Shared\Core\Criteria\Order;
use Npl\Domain\Shared\Core\Criteria\ValueFilter;

final class RightsLoader implements RightsLoaderService
{
    public function __construct(
        private readonly ResourceRepository $resourceRepository,
        private readonly RightRepository $rightRepository
    ) {
    }

    public function load(ResourceName $resourceName): Rights
    {
        $resourceNameFilters = new Filters(
            [
                new ValueFilter(
                    new FilterField('name'),
                    FilterOperator::EQUAL,
                    new FilterValue($resourceName->getValue())
                )
            ]
        );
        $resourceNameCriteria = new Criteria(
            $resourceNameFilters,
            Order::none(),
            null,
            1
        );
        $resources = $this->resourceRepository->loadByCriteria($resourceNameCriteria);

        if (count($resources) > 0) {
            try {
                $resourceItems = $resources->getResources();
                $resource = $resourceItems[0];
                $resourceId = $resource->getResourceId();
                $rightsFilters = new Filters(
                    [
                        new ValueFilter(
                            new FilterField('resource_id'),
                            FilterOperator::EQUAL,
                            new FilterValue((string)$resourceId->getValue())
                        )
                    ]
                );
                $rightsCriteria = new Criteria(
                    $rightsFilters,
                    Order::none(),
                    null,
                    null
                );
                $rights = $this->rightRepository->loadByCriteria($rightsCriteria);
            } catch (Exception) {
                $rights = new Rights([]);
            }
        } else {
            $rights = new Rights([]);
        }

        return $rights;
    }
}
