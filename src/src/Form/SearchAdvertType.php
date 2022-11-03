<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;


class SearchAdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('keyword', TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Maison en ruines, jean troué...',
                )
            ])
            ->add('search', SubmitType::class, [
                'label' => "<span>Rechercher</span><svg class='white-magnifying-glass' width='22' height='22' viewBox='0 0 22 22' fill='none' xmlns='http://www.w3.org/2000/svg'><circle cx='8.5' cy='8.5' r='7' stroke='white' stroke-width='3'/><path d='M15 15L19 19' stroke='white' stroke-width='3' stroke-linecap='square'/></svg>",
                'label_html' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
