<?php

namespace TFounder\Domain\Security\Login;

interface LoginPresenterInterface
{
    public function presents(LoginResponse $response);
}
