<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

class NonUniqueEmail extends Constraint
{
    public string $message = "This email address is already in use.";
}
