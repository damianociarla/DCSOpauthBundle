<?php

namespace DCS\OpauthBundle\Configuration;

use DCS\OpauthBundle\Exception\StrategyNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class StrategyParser implements StrategyParserInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var array
     */
    protected $callParams;

    /**
     * @var array
     */
    protected $strategies;

    function __construct(RouterInterface $router, $callParams, array $strategies = array())
    {
        $this->router = $router;
        $this->callParams = $callParams;
        $this->strategies = $strategies;
    }

    /**
     * Get the configuration of the strategy
     *
     * @param string $strategy
     * @return array
     * @throws \DCS\OpauthBundle\Exception\StrategyNotFoundException
     */
    public function get($strategy)
    {
        if (!isset($this->strategies[$strategy])) {
            throw new StrategyNotFoundException(sprintf('Strategy "%s" not found in the configurations set', $strategy));
        }

        return $this->buildConfiguration($strategy, $this->strategies[$strategy]);
    }

    /**
     * Build the configuration params for the Opauth library
     *
     * @param $strategy
     * @param $strategyConfig
     * @return array
     */
    protected function buildConfiguration($strategy, $strategyConfig)
    {
        $config = array_merge($this->callParams, array(
            'path' => rtrim($this->router->generate('dcs_opauth_connect'), '/').'/',
            'callback_url' => $this->router->generate('dcs_opauth_response', array(
                'strategy' => $strategy,
            )),
            'security_salt' => uniqid(null, true),
        ));

        if (isset($strategyConfig['options']) && is_array($strategyConfig['options'])) {
            $strategyConfig = array_merge($strategyConfig, $strategyConfig['options']);
            unset($strategyConfig['options']);
        }

        $config['Strategy'][$strategy] = $strategyConfig;

        return $config;
    }
} 