<?php

namespace App\UserInterface\Controller;

use App\UserInterface\Forms\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use TFounder\Domain\Security\Registration\Registration;
use TFounder\Domain\Security\Registration\RegistrationPresenterInterface;
use TFounder\Domain\Security\Registration\RegistrationRequest;

/**
 * Class RegistrationController
 * @package App\UserInterface\Controller
 */
class RegistrationController extends AbstractController
{
    private RegistrationPresenterInterface $presenter;

    /**
     * RegistrationController constructor.
     * @param RegistrationPresenterInterface $presenter
     */
    public function __construct(RegistrationPresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }

    public function __invoke(Request $httpRequest, Registration $registration)
    {
        $registrationForm = $this->createForm(RegistrationType::class)->handleRequest($httpRequest);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $request = new RegistrationRequest(
                $registrationForm->getData()->getPseudo(),
                $registrationForm->getData()->getEmail(),
                $registrationForm->getData()->getPlainPassword()
            );

            $registration->execute($request, $this->presenter);

            return $this->redirectToRoute('home');
        }

        return $this->render('security/register.html.twig', ['registrationForm' => $registrationForm->createView()]);
    }
}
