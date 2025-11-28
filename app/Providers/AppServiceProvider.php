<?php

namespace App\Providers;

use App\Models\WorkOrderModel;
use App\Observers\WorkOrderObserver;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        WorkOrderModel::observe(WorkOrderObserver::class);
    }
}
