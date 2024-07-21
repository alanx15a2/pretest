<?php

namespace App\Providers;

use App\Application\Domain\Services\OrderService;
use App\Application\Port\In\OrderUseCase;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrderUseCase::class, OrderService::class);
    }
}
