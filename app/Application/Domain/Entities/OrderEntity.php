<?php

namespace App\Application\Domain\Entities;

use App\Application\Domain\ValueObjects\Address;
use App\Application\Domain\ValueObjects\Currency;

class OrderEntity
{
    private string $id;
    private string $name;
    private Address $address;
    private int $price;
    private Currency $currency;

    public function __construct(
        string $id,
        string $name,
        Address $address,
        int $price,
        Currency $currency
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->price = $price;
        $this->currency = $currency;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function convertCurrency(array $exchangeRate, Currency $fromCurrency, Currency $toCurrency): void
    {
        if (isset($exchangeRate[$fromCurrency->value][$toCurrency->value])) {
            $this->currency = $toCurrency;
            $this->price = (int)($this->price * $exchangeRate[$fromCurrency->value][$toCurrency->value]);
        } else {
            throw new \UnexpectedValueException('Target currency exchange rate does not exist.');
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address->toArray(),
            'price' => $this->price,
            'currency' => $this->currency->value,
        ];
    }
}
