<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; 
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
         * Mendaftarkan ProductPolicy untuk model Product.
         * Digunakan untuk mengatur siapa yang boleh edit/hapus data produk tertentu.
         */
        Gate::policy(Product::class, ProductPolicy::class);

        /**
         * Gate 'manage-product': Rules untuk akses fitur produk.
         * Hanya user dengan role 'admin' yang bisa menambah atau mengelola produk secara umum.
         */
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });

        /**
         * Gate 'manage-category': Rules khusus untuk fitur Kategori.
         * hanya Admin yang boleh menambah atau mengelola kategori.
         */
        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
        });
    }
}