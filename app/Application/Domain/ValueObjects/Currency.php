<?php

namespace App\Application\Domain\ValueObjects;

enum Currency: string
{
    case USD = 'USD';
    case TWD = 'TWD';
}
