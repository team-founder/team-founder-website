<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

class NonUniquePseudonym extends Constraint
{
    public string $message = "This pseudonym is already in use.";
}
