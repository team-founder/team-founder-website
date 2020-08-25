<?php

namespace App\UserInterface\Controller;

use App\UserInterface\ViewModel\LoginViewModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public function __invoke(AuthenticationUtils $utils)
    {
        return $this->render('security/login.html.twig', [
            'vm' => LoginViewModel::createFromAuthenticationUtils($utils)
        ]);
    }
}
