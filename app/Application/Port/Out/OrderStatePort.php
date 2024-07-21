<?php

namespace App\Application\Port\Out;

use App\Application\Domain\Entities\OrderEntity;

Interface OrderStatePort
{
    public function convert(OrderEntity $order): array;
}
