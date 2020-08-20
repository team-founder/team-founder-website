<?php

namespace TFounder\Domain\Security\Registration;

interface RegistrationPresenterInterface
{
    public function presents(RegistrationResponse $response);
}
