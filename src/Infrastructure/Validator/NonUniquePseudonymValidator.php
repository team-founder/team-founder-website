<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use TFounder\Domain\Security\Gateway\UserGateway;

class NonUniquePseudonymValidator extends ConstraintValidator
{
    private UserGateway $gateway;

    /**
     * NonUniquePseudonymValidator constructor.
     * @param UserGateway $gateway
     */
    public function __construct(UserGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($this->gateway->isPseudonymAlreadyInUse($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
