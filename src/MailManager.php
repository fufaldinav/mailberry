<?php

namespace Fufaldinav\Mailberry;

class MailManager extends \Illuminate\Mail\MailManager
{
    /**
     * Resolve the given mailer.
     *
     * @param  string  $name
     * @return \Illuminate\Mail\Mailer
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Mailer [{$name}] is not defined.");
        }

        // Будет создан экземпляр нашего класса Mailer, оператор use не используется
        $mailer = new Mailer(
            $name,
            $this->app['view'],
            $this->createSwiftMailer($config),
            $this->app['events']
        );

        if ($this->app->bound('queue')) {
            $mailer->setQueue($this->app['queue']);
        }

        foreach (['from', 'reply_to', 'to', 'return_path'] as $type) {
            $this->setGlobalAddress($mailer, $config, $type);
        }

        return $mailer;
    }
}