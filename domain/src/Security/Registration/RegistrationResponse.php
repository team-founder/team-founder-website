<?php

namespace TFounder\Domain\Security\Registration;

use TFounder\Domain\Security\Entity\User;

class RegistrationResponse
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}