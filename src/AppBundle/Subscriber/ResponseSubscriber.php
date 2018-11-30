<?php

namespace AppBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onResponse'
        ];
    }

    public function onResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $response->headers->set('Allow', 'GET, POST');
        $response->headers->set('Accept-Language', 'hr;q=1, en;q=0.7');
        $response->headers->set('Accept-Encoding', 'gzip, deflate');
        $response->headers->set('Content-Language', 'hr, en');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block;');
    }
}
