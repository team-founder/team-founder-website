<?php

namespace TFounder\Domain\Security\Gateway;

use TFounder\Domain\Security\Entity\User;

interface UserGateway
{
    public function register(User $user): void;
}
