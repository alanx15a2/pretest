<?php

namespace App\Application\Port\In;

class AddressDto
{
    private string $city;
    private string $district;
    private string $street;

    public function __construct(string $city, string $district, string $street)
    {
        $this->city = $city;
        $this->district = $district;
        $this->street = $street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getDistrict(): string
    {
        return $this->district;
    }

    public function getStreet(): string
    {
        return $this->street;
    }
}
