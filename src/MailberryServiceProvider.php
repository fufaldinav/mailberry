<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MailberryServiceProvider extends ServiceProvider
{
    /**
     * Адресат для получения всех писем вне production.
     *
     * @var array
     */
    protected $to;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/mailberry.php',
            'mailberry'
        );

        $this->to = config('mailberry.to');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/mailberry.php' => config_path('mailberry.php'),
        ]);
    }
}