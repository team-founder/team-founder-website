<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use TFounder\Domain\Security\Gateway\UserGateway;

class NonUniqueEmailValidator extends ConstraintValidator
{
    public UserGateway $gateway;

    /**
     * NonUniqueEmailValidator constructor.
     * @param UserGateway $gateway
     */
    public function __construct(UserGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($this->gateway->isEmailAlreadyInUse($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
