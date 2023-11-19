<?php

namespace App\Providers;

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
        $params = collect([
            'title' => "PT RITEL TOKO RUMAH TANGGA",
            'author' => "-",
            'style' => "read",
            'keyword' => "Cari perlengkapan rumah tangga terlengkap dan terpercaya",
            'description1' => "PT Ritel Toko Rumah menyediakan berbagai barang yang mengutamakan kualitas dan ketahanan",
            'description2' => "PT Ritel Toko Rumah menyediakan berbagai barang yang mengutamakan kualitas dan ketahanan"
        ]);
        session(['headers' => $params]);
    }
}
