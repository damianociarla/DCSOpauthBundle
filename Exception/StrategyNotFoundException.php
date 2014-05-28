<?php

namespace DCS\OpauthBundle\Exception;

use Exception;

/**
 * StrategyNotFoundException
 *
 * @package DCS\OpauthBundle\Exception
 */
class StrategyNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 