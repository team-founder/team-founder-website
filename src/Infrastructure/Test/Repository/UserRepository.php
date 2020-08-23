<?php

namespace App\Infrastructure\Test\Repository;

use TFounder\Domain\Security\Entity\User;
use TFounder\Domain\Security\Gateway\UserGateway;

class UserRepository implements UserGateway
{
    public function register(User $user): void
    {
    }

    public function isPseudonymAlreadyInUse($pseudonym): bool
    {
        return in_array($pseudonym, ['used_pseudo']);
    }

    public function isEmailAlreadyInUse($email): bool
    {
        return in_array($email, ['used@email.com']);
    }
}
