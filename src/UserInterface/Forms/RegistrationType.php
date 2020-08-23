<?php

namespace App\UserInterface\Forms;

use App\Infrastructure\Validator\NonUniqueEmail;
use App\Infrastructure\Validator\NonUniquePseudonym;
use App\UserInterface\DataTransferObject\RegistrationDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("pseudo", TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new NonUniquePseudonym()
                ]
            ])
            ->add("email", EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new NonUniqueEmail()
                ]
            ])
            ->add("plainPassword", RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 8])
                ]
            ])
            ->add("register", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', RegistrationDTO::class);
    }
}
