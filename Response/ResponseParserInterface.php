<?php

namespace DCS\OpauthBundle\Response;

interface ResponseParserInterface
{
    /**
     * Parse response of the Opauth object
     *
     * @param \Opauth $opauth
     * @return array
     */
    public function parse(\Opauth $opauth);
} 