<?php

namespace App\Providers;

use App\Contracts\API_Client\Coin\CoinContract;
use App\Contracts\API_Client\User\UserContract;
use App\Services\API_Client\Coin\CoinService;
use App\Services\API_Client\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CoinContract::class, CoinService::class);

        $this->app->bind(UserContract::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
