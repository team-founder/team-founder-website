<?php

namespace App\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use TFounder\Domain\Security\Entity\User;

class SecurityUser implements UserInterface
{
    private User $user;

    /**
     * SecurityUser constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->user->getPassword();
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->user->getEmail();
    }

    public function eraseCredentials()
    {
    }
}
