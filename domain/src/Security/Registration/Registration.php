<?php

namespace TFounder\Domain\Security\Registration;

use TFounder\Domain\Security\Entity\User;
use TFounder\Domain\Security\Gateway\UserGateway;

class Registration
{
    private UserGateway $gateway;

    public function __construct(UserGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function execute(RegistrationRequest $request, RegistrationPresenterInterface $presenter)
    {
        $request->validate();
        $user = User::fromRegistrationRequest($request);
        $this->gateway->register($user);
        $response = new RegistrationResponse($user);
        $presenter->presents($response);
    }
}
