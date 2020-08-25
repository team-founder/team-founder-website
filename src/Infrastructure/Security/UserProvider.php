<?php

namespace App\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use TFounder\Domain\Security\Gateway\UserGateway;

class UserProvider implements UserProviderInterface
{
    private UserGateway $gateway;

    /**
     * UserProvider constructor.
     * @param UserGateway $gateway
     */
    public function __construct(UserGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function loadUserByUsername(string $username): SecurityUser
    {
        return $this->getUserByEmail($username);
    }

    private function getUserByEmail(string $email): SecurityUser
    {
        dump($this->gateway->getUserByEmail($email));
        return new SecurityUser($this->gateway->getUserByEmail($email));
    }

    public function refreshUser(UserInterface $user): SecurityUser
    {
        return $this->getUserByEmail($user->getUsername());
    }

    public function supportsClass(string $class)
    {
        return $class === SecurityUser::class;
    }
}
