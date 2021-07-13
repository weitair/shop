<?php

namespace Addon\Install\Events;

class InstallEvent
{
    public $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }
}
