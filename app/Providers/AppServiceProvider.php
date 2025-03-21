<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('ticket', function ($app) {
            return new \App\Services\TicketService();
        });
        $this->app->singleton('ticketHistory', function ($app) {
            return new \App\Services\TicketHistoryService();
        });
        $this->app->singleton('user', function ($app) {
            return new \App\Services\UserService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
    protected $policies = [
        User::class => UserPolicy::class,
        Ticket::class => TicketPolicy::class,
    ];
}
