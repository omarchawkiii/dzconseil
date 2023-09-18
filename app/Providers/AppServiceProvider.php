<?php

namespace App\Providers;

use App\Providers\Macros\RequestMacros;
use App\Providers\Macros\TestingMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMacros();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerMacros()
    {
        TestResponse::mixin(new TestingMacros());
    }
}
