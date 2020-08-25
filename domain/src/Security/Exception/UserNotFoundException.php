<?php

namespace TFounder\Domain\Security\Exception;

use Exception;

class UserNotFoundException extends Exception
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct("No user has been found.");
    }
}
