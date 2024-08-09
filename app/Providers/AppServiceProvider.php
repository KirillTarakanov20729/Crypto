<?php

namespace App\Providers;

use App\Contracts\API_Client\Admin\AdminContract;
use App\Contracts\API_Client\Bid\BidContract;
use App\Contracts\API_Client\Coin\CoinContract;
use App\Contracts\API_Client\Currency\CurrencyContract;
use App\Contracts\API_Client\User\UserContract;
use App\Contracts\API_Telegram\Auth\AuthContract;
use App\Contracts\API_Telegram\Balance\BalanceContract;
use App\Services\API_Client\Admin\AdminService;
use App\Services\API_Client\Bid\BidService;
use App\Services\API_Client\Coin\CoinService;
use App\Services\API_Client\Currency\CurrencyService;
use App\Services\API_Client\User\UserService;
use App\Services\API_Telegram\Auth\AuthService;
use App\Services\API_Telegram\Balance\BalanceService;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CoinContract::class, CoinService::class);

        $this->app->bind(UserContract::class, UserService::class);

        $this->app->bind(CurrencyContract::class, CurrencyService::class);

        $this->app->bind(BidContract::class, BidService::class);

        $this->app->bind(AdminContract::class, AdminService::class);

        $this->app->bind(AuthContract::class, AuthService::class);

        $this->app->bind(BalanceContract::class, BalanceService::class);

        $this->app->bind(\App\Contracts\API_Telegram\Coin\CoinContract::class, \App\Services\API_Telegram\Coin\CoinService::class);

        if (class_exists(TelescopeApplicationServiceProvider::class)) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
