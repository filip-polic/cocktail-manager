<?php

namespace AppBundle\Twig\Extension;

class UnescapeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('unescape', array($this, 'unescape')),
        );
    }

    public function unescape($value)
    {
        return html_entity_decode($value);
    }
}
