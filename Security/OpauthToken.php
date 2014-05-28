<?php

namespace DCS\OpauthBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class OpauthToken extends AbstractToken
{
    private $uid;

    private $provider;

    private $info;

    private $credentials;

    private $raw;

    public function __construct($response, array $roles = array())
    {
        $this->uid          = $response['auth']['uid'];
        $this->provider     = $response['auth']['provider'];
        $this->info         = $response['auth']['info'];
        $this->credentials  = $response['auth']['credentials'];
        $this->raw     = $response;

        parent::__construct($roles);

        $this->setUser($response['auth']['info']['name']);
        $this->setAuthenticated(true);
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return mixed
     */
    public function getCredentials()
    {
        return '';
    }

    /**
     * @return array
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(
            array(
                $this->uid,
                $this->provider,
                $this->info,
                $this->credentials,
                $this->raw,
                parent::serialize(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->uid, $this->provider, $this->info, $this->credentials, $this->raw, $parentStr) = unserialize($serialized);
        parent::unserialize($parentStr);
    }
}