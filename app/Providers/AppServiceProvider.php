<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();
        Model::unguard();

        DB::prohibitDestructiveCommands(app()->isProduction());

        Http::preventStrayRequests();

        Date::use(CarbonImmutable::class);

        URL::forceHttps(app()->isProduction());

        Blueprint::macro('commonColumns', function () {
            /** @var Blueprint $this */
            $this->integer('status')->default(0)->nullable(false);
            $this->dateTime('created_at')->nullable(false);
            $this->dateTime('updated_at')->nullable();
            $this->dateTime('deleted_at')->nullable();
            $this->integer('created_by')->nullable(false);
            $this->integer('updated_by')->nullable();
            $this->integer('deleted_by')->nullable();
        });
    }
}
