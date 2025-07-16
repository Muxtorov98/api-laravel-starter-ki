<?php

namespace App\Providers;

use App\Services\Concretes\AuthService;
use App\Services\Concretes\UserService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceClassProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // We don't bind BaseServiceInterface to BaseService anymore since BaseService is now abstract

        // Bind UserServiceInterface to UserService
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
