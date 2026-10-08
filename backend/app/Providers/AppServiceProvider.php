<?php

namespace App\Providers;

use App\Support\Tenancy\CurrentTeam;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Scoped: reset for every request and queued job.
        $this->app->scoped(CurrentTeam::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
