<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core;

use Npl\Domain\AccessControl\Application\Ports\RoleRepository;
use Npl\Domain\AccessControl\Core\Authorization\Role\Role;
use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Criteria\FilterField;
use Npl\Domain\Shared\Core\Criteria\FilterOperator;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\FilterValue;
use Npl\Domain\Shared\Core\Criteria\Order;
use Npl\Domain\Shared\Core\Criteria\ValueFilter;
use Npl\Domain\Shared\Core\NotFoundException;

final class GuestRoleLoader implements GuestRoleLoaderService
{
    public function __construct(private readonly RoleRepository $roleRepository)
    {
    }

    public function load(): Role
    {
        $guestNameFilters = new Filters(
            [
                new ValueFilter(
                    new FilterField('name'),
                    FilterOperator::EQUAL,
                    new FilterValue(Role::GUEST)
                )
            ]
        );
        $guestNameCriteria = new Criteria(
            $guestNameFilters,
            Order::none(),
            null,
            1
        );
        $roleCollection = $this->roleRepository->loadByCriteria($guestNameCriteria);

        if (count($roleCollection) === 0) {
            throw new NotFoundException('The guest role could not be found!');
        }

        $roles = $roleCollection->getRoles();

        return $roles[0];
    }
}
