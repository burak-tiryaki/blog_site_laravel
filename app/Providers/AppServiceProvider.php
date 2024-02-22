<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use PSpell\Config;
use stdClass;

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

        $GlobalViewData = new stdClass();
        $GlobalViewData->siteTitle = empty(config('app.custom_site_title')) ? '': config('app.custom_site_title');
        $GlobalViewData->siteLogo = empty(config('app.custom_site_logo')) ? '': config('app.custom_site_logo');
        $GlobalViewData->isActive = config('app.custom_site_active');
        
       view()->share('config',$GlobalViewData);
    }
}
