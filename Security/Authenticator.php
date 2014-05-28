<?php

namespace DCS\OpauthBundle\Security;

use Symfony\Component\Security\Core\SecurityContextInterface;

class Authenticator implements AuthenticatorInterface
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var array
     */
    protected $roles;

    function __construct(SecurityContextInterface $securityContext, array $roles)
    {
        $this->securityContext = $securityContext;
        $this->roles = $roles;
    }

    /**
     * Set token with the response data
     *
     * @param $responseData
     */
    public function authenticate($responseData)
    {
        $token = new OpauthToken($responseData, $this->roles);
        $this->securityContext->setToken($token);
    }
} 