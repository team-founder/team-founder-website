<?php

namespace TFounder\Domain\Security\Exception;

use Exception;

class InvalidCredentialsException extends Exception
{
    /**
     * InvalidCredentialsException constructor.
     */
    public function __construct()
    {
        parent::__construct("Invalid credentials provided");
    }
}
