<?php

namespace App\Http\Controllers;

use App\Adapter\Out\Web\OrderState;
use App\Application\Domain\ValueObjects\Currency;
use App\Application\Port\In\AddressDto;
use App\Application\Port\In\OrderDto;
use App\Application\Port\In\OrderUseCase;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, OrderUseCase $service)
    {
        $validated = $request->validated();

        try {
            $rs = $service->order(new OrderDto(
                $validated['id'],
                $validated['name'],
                $validated['price'],
                Currency::from($validated['currency']),
                config('exchange_rate'),
                new AddressDto(
                    $validated['address']['city'],
                    $validated['address']['district'],
                    $validated['address']['street'],
                ),
            ), new OrderState());
        } catch (\UnexpectedValueException $e) {
            return response()->json(['message'=>$e->getMessage()], status: 400);
        }

        return response()->json($rs);
    }
}
