<?php

namespace TFounder\Domain\Security\Login;

use TFounder\Domain\Security\Exception\InvalidCredentialsException;
use TFounder\Domain\Security\Exception\UserNotFoundException;
use TFounder\Domain\Security\Gateway\UserGateway;

class Login
{
    private UserGateway $gateway;

    /**
     * Login constructor.
     * @param UserGateway $gateway
     */
    public function __construct(UserGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param LoginRequest $request
     * @param LoginPresenterInterface $presenter
     * @throws UserNotFoundException
     * @throws InvalidCredentialsException
     */
    public function execute(LoginRequest $request, LoginPresenterInterface $presenter)
    {
        $user = $this->gateway->getUserByEmail($request->getEmail());

        if ($user && !password_verify($request->getPlainPassword(), $user->getPassword())) {
            throw new InvalidCredentialsException();
        } elseif (!$user) {
            throw new UserNotFoundException();
        }

        $response = new LoginResponse($user);
        $presenter->presents($response);
    }
}
