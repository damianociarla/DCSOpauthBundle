<?php

namespace DCS\OpauthBundle\Event;

use Symfony\Component\HttpFoundation\Response;

class OpauthResponseEvent extends OpauthEvent
{
    /**
     * @var array
     */
    private $responseData;

    /**
     * @var bool
     */
    private $authenticate;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var bool
     */
    private $valid;

    function __construct(\Opauth $opauth, array $responseData, $valid)
    {
        parent::__construct($opauth);

        $this->responseData = $responseData;
        $this->authenticate = true;
        $this->valid = $valid;
    }

    /**
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @param boolean $authenticate
     */
    public function setAuthenticate($authenticate)
    {
        $this->authenticate = $authenticate;
    }

    /**
     * @return boolean
     */
    public function getAuthenticate()
    {
        return $this->authenticate;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    public function setResponse(Response $response = null)
    {
        $this->response = $response;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->valid;
    }
}