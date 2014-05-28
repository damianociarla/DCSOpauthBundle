<?php

namespace DCS\OpauthBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class OpauthEvent extends Event
{
    private $opauth;

    function __construct(\Opauth $opauth)
    {
        $this->opauth = $opauth;
    }

    /**
     * @return \Opauth
     */
    public function getOpauth()
    {
        return $this->opauth;
    }
}