<?php

namespace App\Providers;


use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LoginSecurity;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard'; // Redirect to dashboard after login

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        $this->configureRateLimiting();

        // Load routes based on the app configuration (web, API routes)
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });

        $this->routes(function () {
            Route::middleware(['web', 'auth', AdminMiddleware::class]) // Apply AdminMiddleware
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php')); // Separate admin routes file for better organization
        });

        Route::middleware('web')
            ->group(function () {
                Route::middleware(LoginSecurity::class)
                    ->group(base_path('routes/auth.php'));
            });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
