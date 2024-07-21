<?php

namespace App\Application\Domain\ValueObjects;

readonly class Address
{
    private string $city;
    private string $district;
    private string $street;

    public function __construct(
        string $city,
        string $district,
        string $street
    )
    {
        $this->city = $city;
        $this->district = $district;
        $this->street = $street;
    }

    public function toArray(): array
    {
        return [
            'city' => $this->city,
            'district' => $this->district,
            'street' => $this->street,
        ];
    }
}
