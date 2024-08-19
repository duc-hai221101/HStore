<?php

namespace App\Providers;

use App\Policies\SettingPolicy;
use App\Services\GateAndPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Gate;
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
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        $this->defineGateSetting();
        //Define Permissions
        $gateAndPolicy = new GateAndPolicy();
        $gateAndPolicy->setGateAndPolicy();

    }
    public function defineGateSetting(){
        Gate::define('setting-list', [SettingPolicy::class, 'view']);
        Gate::define('setting-add', [SettingPolicy::class, 'create']);
        Gate::define('setting-edit', [SettingPolicy::class, 'update']);
        Gate::define('setting-delete', [SettingPolicy::class, 'delete']);
    }
   
}
