<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => [
                    new NotBlank(
                        message: 'Ce champs ne peut pas être vide !'
                    )
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => [
                    new NotBlank(
                        message: 'Ce champs ne peut pas être vide !'
                    )
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Votre adresse email',
                'constraints' => [
                    new Email(
                        message: '{{ value }} n\'est pas une addresse mail valide !'
                    ),
                    new NotBlank(
                        message: 'L\'adresse mail ne peut pas être vide !'
                    )
                ]
            ])
            ->add('object', TextType::class, [
                'label' => 'Objet de votre demande',
                'constraints' => [
                    new NotBlank(
                        message: 'L\'objet ne peut pas être vide !'
                    ),
                    new Length(
                        min: 5,
                        max: 100,
                        minMessage: 'L\'objet doit avoir au moins {{ limit }} caractères !',
                        maxMessage: 'L\'objet ne doit pas dépasser {{ limit }} caractères !'
                    )
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre message',
                'constraints' => [
                    new NotBlank(
                        message: 'Le contenue ne peut pas être vide !'
                    ),
                    new Length(
                        min: 20,
                        max: 100,
                        minMessage: 'Le message doit avoir au moins {{ limit }} caractères !',
                        maxMessage: 'L\'objet ne doit pas dépasser {{ limit }} caractères !'
                    )
                ]
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
