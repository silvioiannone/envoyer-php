<?php

namespace SilvioIannone\EnvoyerPhp\Exceptions;

use Throwable;

/**
 * Exception thrown whenever an unathorized response is received.
 */
class Unauthorized extends \Exception
{
    /**
     * Unauthorized constructor.
     */
    public function __construct()
    {
        parent::__construct('No valid API Key was given.', 401);
    }
}
