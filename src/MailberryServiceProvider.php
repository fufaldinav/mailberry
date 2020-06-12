<?php

namespace Fufaldinav\Mailberry;

class MailberryServiceProvider extends \Illuminate\Mail\MailServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/mailberry.php',
            'mailberry'
        );

        parent::register();
    }

    /**
     * Переопределенный метод MailServiceProvider
     *
     * @return void
     */
    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mail.manager', function ($app) {
            // Будет создан экземпляр нашего класса MailManager, оператор use не используется
            return new MailManager($app);
        });

        $this->app->bind('mailer', function ($app) {
            return $app->make('mail.manager')->mailer();
        });
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