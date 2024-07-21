<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_correct_twd_order()
    {
        $requestJson = '{"id": "A0000001","name": "Melody Holiday Inn","address": {"city": "taipei-city","district": "da-an-district","street": "fuxing-south-road"},"price": "1000","currency": "TWD"}';
        $requestData = json_decode($requestJson, true);

        $response = $this->postJson('api/orders', $requestData);
        $response->assertStatus(200);
        $response->assertJson($requestData);
    }

    public function test_need_convert_currency()
    {
        $requestJson = '{"id": "A0000001","name": "Melody Holiday Inn","address": {"city": "taipei-city","district": "da-an-district","street": "fuxing-south-road"},"price": "50","currency": "USD"}';
        $requestData = json_decode($requestJson, true);

        $assertData = $requestData;
        $assertData['currency'] = 'TWD';
        $assertData['price'] = 50 * config('exchange_rate.USD.TWD');

        $response = $this->postJson('api/orders', $requestData);
        $response->assertStatus(200)
            ->assertJson($assertData);
    }

    public function test_price_greater_than_limit_after_convert_currency()
    {
        $requestJson = '{"id": "A0000001","name": "Melody Holiday Inn","address": {"city": "taipei-city","district": "da-an-district","street": "fuxing-south-road"},"price": "100","currency": "USD"}';
        $requestData = json_decode($requestJson, true);

        $assertData = $requestData;
        $assertData['currency'] = 'TWD';
        $assertData['price'] = 50 * config('exchange_rate.USD.TWD');

        $response = $this->postJson('api/orders', $requestData);
        $response->assertStatus(400)
            ->assertSee('Price is over 2000.');
    }

    public function test_name_contains_non_english_character()
    {
        $requestJson = '{"id": "A0000001","name": "Melody-Holiday Inn","address": {"city": "taipei-city","district": "da-an-district","street": "fuxing-south-road"},"price": "1000","currency": "TWD"}';
        $requestData = json_decode($requestJson, true);

        $response = $this->postJson('api/orders', $requestData);
        $response->assertStatus(400)
            ->assertSee('Name contains non-english character.');
    }

    public function test_name_is_not_capitalized()
    {
        $requestJson = '{"id": "A0000001","name": "melody Holiday Inn","address": {"city": "taipei-city","district": "da-an-district","street": "fuxing-south-road"},"price": "1000","currency": "TWD"}';
        $requestData = json_decode($requestJson, true);

        $response = $this->postJson('api/orders', $requestData);
        $response->assertStatus(400)
            ->assertSee('Name is not capitalized.');
    }

    public function test_price_is_over_2000()
    {
        $requestJson = '{"id": "A0000001","name": "Melody Holiday Inn","address": {"city": "taipei-city","district": "da-an-district","street": "fuxing-south-road"},"price": "2050","currency": "TWD"}';
        $requestData = json_decode($requestJson, true);

        $response = $this->postJson('api/orders', $requestData);
        $response->assertStatus(400)
            ->assertSee('Price is over 2000.');
    }

    public function test_currency_format_is_wrong()
    {
        $requestJson = '{"id": "A0000001","name": "Melody Holiday Inn","address": {"city": "taipei-city","district": "da-an-district","street": "fuxing-south-road"},"price": "1000","currency": "XXX"}';
        $requestData = json_decode($requestJson, true);

        $response = $this->postJson('api/orders', $requestData);
        $response->assertStatus(400)
            ->assertSee('Currency is wrong.');
    }
}
