<?php

namespace App\Application\Port\In;

use App\Application\Port\Out\OrderStatePort;

Interface OrderUseCase
{
    public function order(OrderDto $orderDto, OrderStatePort $orderStatePort);
}
