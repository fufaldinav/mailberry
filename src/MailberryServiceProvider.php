<?php

namespace Fufaldinav\Mailberry;

use Illuminate\Support\Facades\App;
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
        ], 'mailberry-config');

        if (!App::environment('production') && isset($this->to['address'])) {
            config(['mail.to' => $this->to]);
        }
    }
}