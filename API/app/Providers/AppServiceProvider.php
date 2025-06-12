<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

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
        Response::macro('success', function ($data = null, $message = 'Operação realizada com sucesso.', $code = 200) {
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => $message
            ], $code);
        });
    }
}
