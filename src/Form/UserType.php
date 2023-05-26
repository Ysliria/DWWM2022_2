<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email'
            ])
            ->add('password', RepeatedType::class, [
                'type'            => PasswordType::class,
                'invalid_message' => 'Le mot de passe et sa confirmation ne correspondent pas !',
                'first_options'   => [
                    'label' => 'Votre mot de passe',
                    'hash_property_path' => 'password' // Permet de forcer le hash directement
                ],
                'second_options'  => [
                    'label' => 'Confirmez votre mot de passe'
                ],
                'mapped' => false // obligatoire avec hash_property_path @see https://symfony.com/doc/current/reference/forms/types/password.html#hash-property-path
            ])
            ->add('phone', TextType::class, [
                'label'    => 'Votre numéro de téléphone',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
