<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        Response::macro('success', function ($value) {
            return Response::make([
                'status' => 'success',
                'data' => $value
            ]);
        });

        Response::macro('fail', function ($value) {
            return Response::make([
                'status' => 'fail',
                'data' => $value
            ]);
        });
    }
}
