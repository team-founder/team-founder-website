<?php

namespace App\Infrastructure\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use TFounder\Domain\Security\Exception\InvalidCredentialsException;
use TFounder\Domain\Security\Exception\UserNotFoundException;
use TFounder\Domain\Security\Login\Login;
use TFounder\Domain\Security\Login\LoginPresenterInterface;
use TFounder\Domain\Security\Login\LoginRequest;
use TFounder\Domain\Security\Login\LoginResponse;

class WebAuthenticator extends AbstractFormLoginAuthenticator implements LoginPresenterInterface
{
    private Login $login;

    private LoginResponse $response;

    /**
     * WebAuthenticator constructor.
     * @param Login $login
     */
    public function __construct(Login $login)
    {
        $this->login = $login;
    }

    public function supports(Request $request)
    {
        return $this->getLoginUrl() === $request->getPathInfo() && $request->isMethod(Request::METHOD_POST);
    }

    protected function getLoginUrl()
    {
        return "/login";
    }

    public function getCredentials(Request $request)
    {
        return new LoginRequest(
            $request->get("email", ""),
            $request->get("password", "")
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $this->login->execute($credentials, $this);
            return new SecurityUser($this->response->getUser());
        } catch (UserNotFoundException $e) {
            throw new UsernameNotFoundException($e->getMessage());
        } catch (InvalidCredentialsException $e) {
            throw new AuthenticationException($e->getMessage());
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return new RedirectResponse("/");
    }

    public function presents(LoginResponse $response)
    {
        $this->response = $response;
    }
}
