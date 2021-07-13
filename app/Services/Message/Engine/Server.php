<?php

namespace App\Services\Message\Engine;

abstract class Server
{
    protected $config;

    protected $template;

    protected function __construct(array $config = [])
    {
        $this->config = $config;
    }

    abstract public function send(string $to, array $content);

    public function template(string $template)
    {
        $this->template = $template;
        return $this;
    }
}
