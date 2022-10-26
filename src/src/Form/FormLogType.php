<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
                                                   use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FormLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $bu
 use Symfony\Flex\Response;ilder, array $options): void
    {
        $builder
            ->add(child:'email', type:EmailType::class)
            ->add(child:'firstname')
            ->add(child:'lasname')
            ->add(child:'password', type:PasswordType::class)
            ->add(child:'plainPassword', type:PasswordType::class,
            ['mapped' => false,
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 5,
                    'minMessage' => 'Votre mot de passe est trop court',
                ])
            ]
            ])
            ->add(child:'submit', type:SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

