<?php

namespace App\Providers;

use App\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $setting = SiteSetting::where('id',1)->first(['site_name','footer_text','meta_title','meta_description']);
            $view->with(['setting' => $setting]);
        });
    }
}
