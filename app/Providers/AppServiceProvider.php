<?php

namespace App\Providers;

use App\SiteSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $site = SiteSetting::where(['id' => 1])->first();

        if ($site) {
            

            Config::set('app.name', $site->site_name);
        }
        else{
            Config::set('app.name', 'BusMama');
        }
    }
}
