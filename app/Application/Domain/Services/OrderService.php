<?php

namespace App\Application\Domain\Services;

use App\Application\Domain\ValueObjects\Address;
use App\Application\Domain\Entities\OrderEntity;
use App\Application\Domain\ValueObjects\Currency;
use App\Application\Port\In\OrderDto;
use App\Application\Port\In\OrderUseCase;
use App\Application\Port\Out\OrderStatePort;

class OrderService implements OrderUseCase
{
    private OrderEntity $order;

    private array $exchangeRate;

    public function order(OrderDto $orderDto, OrderStatePort $orderStatePort): array
    {
        $addressDto = $orderDto->getAddressDto();

        $this->order = new OrderEntity(
            $orderDto->getId(),
            $orderDto->getName(),
            new Address(
                $addressDto->getCity(),
                $addressDto->getDistrict(),
                $addressDto->getStreet(),
            ),
            $orderDto->getPrice(),
            $orderDto->getCurrency()
        );

        $this->exchangeRate = $orderDto->getExchangeRate();

        $this->convertUsdToTwd();
        $this->validateOrderPrice();

        return $orderStatePort->convert($this->order);
    }

    private function convertUsdToTwd(): void
    {
        if ($this->order->getCurrency() == Currency::USD) {
            $this->order->convertCurrency($this->exchangeRate, Currency::USD, Currency::TWD);
        }
    }

    private function validateOrderPrice(): void
    {
        if ($this->order->getPrice() > 2000) {
            throw new \UnexpectedValueException('Price is over 2000.');
        }
    }
}
