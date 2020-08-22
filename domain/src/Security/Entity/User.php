<?php

namespace TFounder\Domain\Security\Entity;

use TFounder\Domain\Security\Registration\RegistrationRequest;

class User
{
    private string $email;
    private string $pseudonym;
    private string $password;

    public function __construct(string $pseudonym, string $email, string $password)
    {
        $this->email = $email;
        $this->pseudonym = $pseudonym;
        $this->password = password_hash($password, PASSWORD_ARGON2I);
    }

    public static function fromRegistrationRequest(RegistrationRequest $request)
    {
        return new self($request->getPseudonym(), $request->getEmail(), $request->getPlainPassword());
    }

    public function getPseudonym(): string
    {
        return $this->pseudonym;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}