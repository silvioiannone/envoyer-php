<?php

namespace SilvioIannone\EnvoyerPhp\Exceptions;

use Throwable;

/**
 * Exception thrown whenever a resource is not found.
 */
class NotFound extends \Exception
{
    /**
     * Unauthorized constructor.
     */
    public function __construct()
    {
        parent::__construct('The request resource could not be found.', 404);
    }
}
