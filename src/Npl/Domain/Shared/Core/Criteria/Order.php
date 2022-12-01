<?php

declare(strict_types=1);

namespace Npl\Domain\Shared\Core\Criteria;

final class Order
{
    public function __construct(private readonly OrderBy $orderBy, private readonly OrderType $orderType)
    {
    }

    public static function fromValues(?string $orderBy, ?string $order): Order
    {
        return null === $orderBy ? self::none() : new Order(
            new OrderBy($orderBy),
            null === $order ? OrderType::NONE : OrderType::from($order)
        );
    }

    public static function none(): Order
    {
        return new Order(
            new OrderBy(''),
            OrderType::NONE
        );
    }

    public function getOrderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function getOrderType(): OrderType
    {
        return $this->orderType;
    }

    public function isNone(): bool
    {
        return $this->orderType->isNone();
    }

    public function serialize(): string
    {
        return sprintf(
            '%s.%s',
            $this->orderBy->getValue(),
            $this->orderType->getValue()
        );
    }
}
