<?php

namespace DCS\OpauthBundle\Configuration;

interface StrategyParserInterface
{
    /**
     * Get the configuration of the strategy
     *
     * @param string $strategy
     * @return array
     */
    public function get($strategy);
} 