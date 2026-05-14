<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;

use Dedoc\Scramble\Scramble;

use App\Models\User;
use App\Models\Product;
use App\Policies\ProductPolicy;

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
     * Tempat untuk mendaftarkan Gate dan Policy akses.
     */
    public function boot(): void
    {
        /**
         * Konfigurasi Scramble
         * Hanya route API yang akan masuk dokumentasi.
         */
        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });

        /**
         * Mengizinkan dokumentasi API diakses saat production.
         */
        Gate::define('viewApiDocs', function () {
            return true;
        });

        /**
         * Mendaftarkan ProductPolicy untuk model Product.
         */
        Gate::policy(Product::class, ProductPolicy::class);

        /**
         * Gate manage-product
         */
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });

        /**
         * Gate manage-category
         */
        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
        });
    }
}