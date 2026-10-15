<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use  Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page'){

            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(

                $this->forPage($page, $perPage),

                $total ?: $this->count(),

                $perPage,

                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Telescope 5's Sentinel middleware calls host(), which was renamed
        // to getHost() in the Laravel 8 request API.
        if (! method_exists(Request::class, 'host')) {
            Request::macro('host', function () {
                return $this->getHost();
            });
        }

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);


        // // General API
        // // 30 requests per minute per authenticated user or IP
        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(30)
        //         ->by($request->user()?->id ?: $request->ip());
        // });

        // // Strict API
        // // 3 requests per minute per authenticated user or IP
        // RateLimiter::for('api-strict', function (Request $request) {
        //     return Limit::perMinute(3)
        //         ->by($request->user()?->id ?: $request->ip());
        // });
        
    }
}
