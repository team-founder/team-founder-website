<?php

namespace TFounder\Domain\Security\Login;

use TFounder\Domain\Security\Entity\User;

class LoginResponse
{
    private ?User $user;

    /**
     * LoginResponse constructor.
     * @param User|null $user
     */
    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
