<?php

namespace App\Providers;
use App\Models\Pedido;
use App\Observers\PedidoObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast; 

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
}
}
