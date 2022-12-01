<?php

declare(strict_types=1);

namespace Npl\Domain\AccessControl\Core;

use Npl\Domain\AccessControl\Application\Ports\UserRoleRepository;
use Npl\Domain\AccessControl\Core\Authorization\UserRole\UserRoles;
use Npl\Domain\Shared\Core\Criteria\Criteria;
use Npl\Domain\Shared\Core\Criteria\FilterField;
use Npl\Domain\Shared\Core\Criteria\FilterOperator;
use Npl\Domain\Shared\Core\Criteria\Filters;
use Npl\Domain\Shared\Core\Criteria\FilterValue;
use Npl\Domain\Shared\Core\Criteria\Order;
use Npl\Domain\Shared\Core\Criteria\ValueFilter;
use Npl\Domain\Shared\Core\User\UserId;

final class UserRolesLoader implements UserRolesLoaderService
{
    public function __construct(
        private readonly UserRoleRepository $userRolesRepository,
    ) {
    }

    public function load(UserId $userId): UserRoles
    {
        $userIdFilters = new Filters(
            [
                new ValueFilter(
                    new FilterField('user_id'),
                    FilterOperator::EQUAL,
                    new FilterValue((string)$userId->getValue())
                )
            ]
        );
        $userIdCriteria = new Criteria(
            $userIdFilters,
            Order::none(),
            null,
            null
        );

        return $this->userRolesRepository->loadByCriteria($userIdCriteria);
    }
}
