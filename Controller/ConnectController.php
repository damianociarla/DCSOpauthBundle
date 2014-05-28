<?php

namespace DCS\OpauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConnectController extends Controller
{
    /**
     * Call the provider for the authentication
     */
    public function loginAction($strategy)
    {
        $config = $this->get('dcs_opauth.strategy_parser')->get($strategy);
        $opauth = new \Opauth($config);
    }
}
