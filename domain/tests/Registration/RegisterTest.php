<?php

namespace TFounder\Domain\Tests\Registration;

use Assert\AssertionFailedException;
use Generator;
use PHPUnit\Framework\TestCase;
use TFounder\Domain\Security\Entity\User;
use TFounder\Domain\Security\Gateway\UserGateway;
use TFounder\Domain\Security\Registration\Registration;
use TFounder\Domain\Security\Registration\RegistrationPresenterInterface;
use TFounder\Domain\Security\Registration\RegistrationRequest;
use TFounder\Domain\Security\Registration\RegistrationResponse;

/**
 * Class RegisterTest
 * @package Domain\Tests\Registration
 */
class RegisterTest extends TestCase
{
    private Registration $useCase;

    private RegistrationPresenterInterface $presenter;

    public function setUp(): void
    {
        parent::setUp();

        $gateway = new class () implements UserGateway {

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
        };

        $this->presenter = new class () implements RegistrationPresenterInterface {
            public RegistrationResponse $response;

            public function presents(RegistrationResponse $response)
            {
                $this->response = $response;
            }
        };

        $this->useCase = new Registration($gateway);
    }

    public function testWithGoodInputs()
    {
        $request = new RegistrationRequest("pseudo", "email@domain.tld", "plainPassword");

        $this->useCase->execute($request, $this->presenter);

        $user = $this->presenter->response->getUser();

        $this->assertInstanceOf(RegistrationResponse::class, $this->presenter->response);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals("pseudo", $user->getPseudonym());
        $this->assertEquals("email@domain.tld", $user->getEmail());
        $this->assertTrue(password_verify("plainPassword", $user->getPassword()));
    }

    /**
     * @dataProvider provideBadRequestData
     * @param string $pseudo
     * @param string $email
     * @param string $plainPassword
     */
    public function testWithBadInputs(string $pseudo, string $email, string $plainPassword)
    {
        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute(new RegistrationRequest($pseudo, $email, $plainPassword), $this->presenter);
    }

    public function provideBadRequestData(): Generator
    {
        yield ["", "email@domain.tld", "plainPassword"];  // Wrong pseudonym: blank
        yield ["pseudonym", "", "plainPassword"];  // Wrong email: blank
        yield ["pseudonym", "email@email", "plainPassword"];  // Wrong email: no extension
        yield ["pseudonym", "email@email.fr", ""];  // Wrong password: blank
        yield ["pseudonym", "email@email.fr", "short"];  // Wrong password: too short
    }
}
