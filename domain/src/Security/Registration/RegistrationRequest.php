<?php

namespace TFounder\Domain\Security\Registration;

use Assert\Assertion;

class RegistrationRequest
{
    private string $pseudonym;
    private string $email;
    private string $plainPassword;

    public function __construct(string $pseudonym, string $email, string $plainPassword)
    {
        $this->email = $email;
        $this->pseudonym = $pseudonym;
        $this->plainPassword = $plainPassword;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPseudonym(): string
    {
        return $this->pseudonym;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function validate()
    {
        Assertion::notBlank($this->pseudonym);
        Assertion::email($this->email);
        Assertion::notBlank($this->plainPassword);
        Assertion::minLength($this->plainPassword, 8);
    }
}
