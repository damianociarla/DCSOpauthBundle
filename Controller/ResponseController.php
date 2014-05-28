<?php

namespace DCS\OpauthBundle\Controller;

use DCS\OpauthBundle\DCSOpauthEvents;
use DCS\OpauthBundle\Event\OpauthEvent;
use DCS\OpauthBundle\Event\OpauthResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ResponseController extends Controller
{
    /**
     * Parse the response of the provider
     */
    public function checkAction($strategy)
    {
        $config = $this->get('dcs_opauth.strategy_parser')->get($strategy);
        $opauth = new \Opauth($config, false);

        $this->dispatchEvent(DCSOpauthEvents::BEFORE_PARSE_RESPONSE, new OpauthEvent($opauth));

        $responseData = $this->get('dcs_opauth.response_parser')->parse($opauth);

        // Check if there are errors from the provider
        $isValid = !isset($responseData['error']);

        $event = new OpauthResponseEvent($opauth, $responseData, $isValid);
        $this->dispatchEvent(DCSOpauthEvents::AFTER_PARSE_RESPONSE, $event);

        // If there are no errors, and authentication is enabled, create the token with the data provider
        if ($isValid && $event->getAuthenticate()) {
            $this->get('dcs_opauth.authenticator')->authenticate($responseData);
        }

        // Verify if the response is set
        if (null === $response = $event->getResponse()) {
            if ($isValid) {
                if (null === $routeRedirect = $this->container->getParameter('dcs_opauth.redirect_after_response')) {
                    $url = '/'.ltrim($this->get('request')->getBaseUrl(), '/');
                } else {
                    // Check if route exists
                    try {
                        $url = $this->generateUrl($routeName);
                    } catch (RouteNotFoundException $e) {
                        $url = $routeName;
                    }
                }
                // Create default response
                $response = new RedirectResponse($url);
            } else {
                $response = $this->render($this->container->getParameter('dcs_opauth.error_view'), $responseData['error']);
            }
        }

        return $response;
    }

    /**
     * Dispatch event
     *
     * @param $eventName
     * @param $event
     */
    private function dispatchEvent($eventName, $event)
    {
        $this->get('event_dispatcher')->dispatch($eventName, $event);
    }
} 