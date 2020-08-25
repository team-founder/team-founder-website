<?php

namespace App\UserInterface\ViewModel;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginViewModel
{
    private string $lastUsername;
    private ?string $error;

    /**
     * LoginViewModel constructor.
     * @param string $lastUsername
     * @param AuthenticationException|null $exception
     */
    public function __construct(string $lastUsername, ?AuthenticationException $exception)
    {
        $this->lastUsername = $lastUsername;
        $this->error = $exception === null ? null : $exception->getMessage();
    }

    public static function createFromAuthenticationUtils(AuthenticationUtils $utils)
    {
        return new self(
            $utils->getLastUsername(),
            $utils->getLastAuthenticationError()
        );
    }

    /**
     * @return string
     */
    public function getLastUsername(): string
    {
        return $this->lastUsername;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
