<?php

namespace App\Controller;

use App\Entity\ComingSoonSubscriber;
use App\Form\ComingSoonSubscribeType;
use App\Repository\ComingSoonSubscriberRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComingSoonSubscribeController extends AbstractController
{
    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param SessionInterface $session
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function __invoke(
        Request $request,
        ValidatorInterface $validator,
        SessionInterface $session,
        EntityManagerInterface $em
    ): Response
    {
        $subscribeForm = $this->createForm(ComingSoonSubscribeType::class);
        $subscribeForm->handleRequest($request);

        if ($subscribeForm->isSubmitted())
        {
            $errors = $validator->validate($subscribeForm);

            if($subscribeForm->isValid())
            {
                $this->addFlash('success', 'Vous serez bien informé par mail &#x1F642; !');
                $em->persist($subscribeForm->getData());
                $em->flush();
            }
            else
            {
                foreach ($errors as $error)
                {
                    $this->addFlash('errors', $error->getMessage() . ' &#128577;');
                }
            }
            return $this->redirectToRoute('coming_soon');
        }

        return $this->render('coming-soon.html.twig', ['form' => $subscribeForm->createView()]);
    }
}
