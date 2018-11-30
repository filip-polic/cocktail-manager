<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class XSSProtector implements EventSubscriberInterface
{

    /** @var NonceGenerator $nonceGenerator */
    private $nonceGenerator;

    public function __construct(NonceGenerator $nonceGenerator)
    {
        // inject the nonce generator service we created in previous steps
        $this->nonceGenerator = $nonceGenerator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        // listen to the kernel.response event
        return [KernelEvents::RESPONSE => 'addCSPHeaderToResponse'];
    }

    /**
     * Adds the Content Security Policy header.
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     * @throws \Exception
     */
    public function addCSPHeaderToResponse(FilterResponseEvent $event)
    {
        // get the Response object from the event
        $response = $event->getResponse();

        // create a CSP rule, using the nonce generator service
        $nonce = $this->nonceGenerator->getNonce();
        $cspHeader = "script-src maps.googleapis.com 'nonce-".$nonce."' https:;object-src 'none';img-src 'self' https:;child-src https://www.google.com;media-src 'none';frame-ancestors 'none';block-all-mixed-content;";

        // set CSP header on the response object
        $response->headers->set("Content-Security-Policy", $cspHeader);
    }
}
