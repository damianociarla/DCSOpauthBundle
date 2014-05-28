<?php

namespace DCS\OpauthBundle\Response;

use DCS\OpauthBundle\Exception\UnsupportedCallbackException;

class ResponseParser implements ResponseParserInterface
{
    /**
     * Parse response of the Opauth object
     *
     * @param \Opauth $opauth
     * @return array
     * @throws \DCS\OpauthBundle\Exception\UnsupportedCallbackException
     */
    public function parse(\Opauth $opauth)
    {
        $callbackTransport = $opauth->env['callback_transport'];

        switch($callbackTransport) {
            case 'session':
                $response = $_SESSION['opauth'];
                unset($_SESSION['opauth']);
                break;
            case 'post':
                $response = unserialize(base64_decode($_POST['opauth']));
                break;
            case 'get':
                $response = unserialize(base64_decode($_GET['opauth']));
                break;
            default:
                throw new UnsupportedCallbackException(sprintf('Callback transport "%s" is not supported. Are only supported: session, post, get', $callbackTransport));
                break;
        }

        return $response;
    }
}