<?php

namespace DCS\OpauthBundle\Security;

interface AuthenticatorInterface
{
    /**
     * Set token with the response data
     *
     * @param $responseData
     */
    public function authenticate($responseData);
}