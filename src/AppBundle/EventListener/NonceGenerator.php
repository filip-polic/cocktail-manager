<?php

namespace AppBundle\EventListener;

class NonceGenerator extends \Twig_Extension
{
    /** @var String|null */
    private $nonce;

    /**
     * Generates a random nonce parameter.
     *
     * @return string
     * @throws \Exception
     */
    public function getNonce()
    {
        // generation occurs only when $this->nonce is still null
        if (!$this->nonce) {
            $this->nonce = base64_encode(random_bytes(20).date('Y-m-d H:i:s'));
        }

        return $this->nonce;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('csp_nonce', [$this, 'getNonce']),
        ];
    }
}
