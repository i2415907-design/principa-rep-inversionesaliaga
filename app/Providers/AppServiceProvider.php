<?php

namespace App\Providers;

use App\Models\Pedido;
use App\Observers\PedidoObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast; 
// 🚀 CORRECCIÓN CLOUD RUN: Importar fachada URL
use Illuminate\Support\Facades\URL;

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
        // Esto permite que Flutter se autentique en Pusher usando tu api_token
        Broadcast::routes(['middleware' => ['api.key']]); 

        \App\Models\Pedido::observe(\App\Observers\PedidoObserver::class);

        // 🚀 CORRECCIÓN CLOUD RUN: Forzar esquemas HTTPS en producción
        if (config('app.env') === 'production' || env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
