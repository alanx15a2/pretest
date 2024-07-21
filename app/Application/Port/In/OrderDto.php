<?php

namespace App\Application\Port\In;

use App\Application\Domain\ValueObjects\Currency;
use Illuminate\Validation\ValidationException;

class OrderDto
{
    private int $price;

    public function __construct(
        private string $id,
        private string $name,
        int $price,
        private Currency $currency,
        private array $exchangeRate,
        private AddressDto $addressDto,
    )
    {
        $this->setPrice($price);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAddressDto(): AddressDto
    {
        return $this->addressDto;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getExchangeRate(): array
    {
        return $this->exchangeRate;
    }

    private function setPrice(int $price)
    {
        if ($price > 2000) {
            throw new ValidationException('Price cannot be greater than 2000');
        }

        $this->price = $price;
    }
}
