<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event;

class VideoCreatedListener extends Event
{

    public function onVideoCreatedEvent($event)
    {


        echo 'work';
        exit;
    }
}
