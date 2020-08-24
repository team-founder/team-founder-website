<?php

namespace TFounder\Domain\Security\Gateway;

use TFounder\Domain\Security\Entity\User;

interface UserGateway
{
    public function register(User $user): void;

    public function isPseudonymAlreadyInUse($pseudonym): bool;

    public function isEmailAlreadyInUse($email): bool;

    public function getUserByEmail(string $email);
}
