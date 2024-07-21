<?php

namespace App\Adapter\Out\Web;

use App\Application\Domain\Entities\OrderEntity;
use App\Application\Port\Out\OrderStatePort;

class OrderState implements OrderStatePort
{
    public function convert(OrderEntity $order): array
    {
        return $order->toArray();
    }
}
