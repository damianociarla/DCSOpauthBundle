<?php

namespace DCS\OpauthBundle;

class DCSOpauthEvents
{
    /**
     * The BEFORE_PARSE_RESPONSE event occurs before parse the response of the provider
     *
     * The event listener method receives a DCS\OpauthBundle\Event\OpauthEvent instance.
     */
    const BEFORE_PARSE_RESPONSE = 'dcs_opauth.event.before_parse_response';

    /**
     * The BEFORE_PARSE_RESPONSE event occurs after parse the response of the provider
     *
     * The event listener method receives a DCS\OpauthBundle\Event\OpauthResponseEvent instance.
     */
    const AFTER_PARSE_RESPONSE = 'dcs_opauth.event.after_parse_response';
}