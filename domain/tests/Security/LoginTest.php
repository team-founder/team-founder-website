<?php

namespace TFounder\Domain\Tests\Security;

use PHPUnit\Framework\TestCase;
use TFounder\Domain\Security\Entity\User;
use TFounder\Domain\Security\Exception\InvalidCredentialsException;
use TFounder\Domain\Security\Exception\UserNotFoundException;
use TFounder\Domain\Security\Gateway\UserGateway;
use TFounder\Domain\Security\Login\Login;
use TFounder\Domain\Security\Login\LoginPresenterInterface;
use TFounder\Domain\Security\Login\LoginRequest;
use TFounder\Domain\Security\Login\LoginResponse;
use TFounder\Domain\Tests\Adapter\UserRepository;

class LoginTest extends TestCase
{
    private UserGateway $gateway;

    private Login $useCase;

    private LoginPresenterInterface $presenter;

    public function setUp(): void
    {
        parent::setUp();
        $this->gateway = new UserRepository();

        $this->presenter = new class () implements LoginPresenterInterface {
            public LoginResponse $response;

            public function presents(LoginResponse $response)
            {
                $this->response = $response;
            }
        };

        $this->useCase = new Login($this->gateway);
    }

    public function testSuccessful()
    {
        $request = new LoginRequest("good@domain.tld", "plainPassword");

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(User::class, $this->presenter->response->getUser());
    }

    public function testNoUserFound()
    {
        $request = new LoginRequest("noemail@domain.tld", "plainPassword");

        $this->expectException(UserNotFoundException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    public function testInvalidPassword()
    {
        $request = new LoginRequest("good@domain.tld", "wrongPassword");

        $this->expectException(InvalidCredentialsException::class);

        $this->useCase->execute($request, $this->presenter);
    }
}
