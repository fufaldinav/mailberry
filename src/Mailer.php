<?php

namespace Fufaldinav\Mailberry;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\App;
use Swift_Mailer;

class Mailer extends \Illuminate\Mail\Mailer
{
    /**
     * Переопределение адресата.
     *
     * @var array
     */
    protected $forcingGlobalToValue = false;

    /**
     * Create a new Mailer instance.
     *
     * @param  string  $name
     * @param  \Illuminate\Contracts\View\Factory  $views
     * @param  \Swift_Mailer  $swift
     * @param  \Illuminate\Contracts\Events\Dispatcher|null  $events
     * @return void
     */
    public function __construct(string $name, Factory $views, Swift_Mailer $swift, Dispatcher $events = null)
    {
        $to = config('mailberry.to');

        if (!App::environment('production')  && isset($to['address'])) {
            $this->forcingGlobalToValue = true;
            $this->to = $to;
        }

        parent::__construct($name, $views, $swift, $events);
    }

    /**
     * Set the global to address and name.
     *
     * @param  string  $address
     * @param  string|null  $name
     * @return void
     */
    public function alwaysTo($address, $name = null)
    {
        // Не даст переопределить наши настройки, сохранив функционал
        if (!$this->forcingGlobalToValue) {
            $this->to = compact('address', 'name');
        }
    }
}