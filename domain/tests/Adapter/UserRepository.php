<?php

namespace TFounder\Domain\Tests\Adapter;

use TFounder\Domain\Security\Entity\User;
use TFounder\Domain\Security\Gateway\UserGateway;

class UserRepository implements UserGateway
{
    public function register(User $user): void
    {
    }

    public function isPseudonymAlreadyInUse($pseudonym): bool
    {
        return false;
    }

    public function isEmailAlreadyInUse($email): bool
    {
        return false;
    }

    public function getUserByEmail(string $email)
    {
        if ($email == "good@domain.tld") {
            return new User("Pseudonym", $email, "plainPassword");
        }
        return null;
    }
}
