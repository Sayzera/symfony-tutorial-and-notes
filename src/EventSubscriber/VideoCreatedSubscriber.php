<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class VideoCreatedSubscriber implements EventSubscriberInterface
{
    public function onVideoCreatedEvent($event): void
    {
        dump('I am VideoCreatedSubscriber', $event);
    }


    public function onVideoCreatedEvent2($event): void
    {
        dump('I am VideoCreatedSubscriber2', $event);
    }

    public function onVideoCreatedEvent1($event): void
    {
        dump('I am VideoCreatedSubscriber1', $event);
    }

    public function onVideoCreatedEvent3($event): void
    {
        dump('I am VideoCreatedSubscriber3', $event);
    }



    public static function getSubscribedEvents(): array
    {
        return [
            'video.created.event' => 'onVideoCreatedEvent',
            KernelEvents::RESPONSE => 'onVideoCreatedEvent', // Tüm response eventlerini yakalar ve onVideoCreatedEvent fonksiyonunu çalıştırır.


            // aboneleri sırasıyla çalıştırır.
            // KernelEvents::RESPONSE => [
            //     ['onVideoCreatedEvent1', 1], // 1. sırada çalışır
            //     ['onVideoCreatedEvent3', 3], // 3. sırada çalışır
            //     ['onVideoCreatedEvent2', 2], // 2. sırada çalışır
            // ]

        ];
    }
}
