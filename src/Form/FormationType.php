<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la formation',
                'attr'  => [
                    'placeholder' => 'Développeur Web et Web Mobile'
                ]
            ])
            ->add('code', TextType::class, [
                'label' => 'Code de la formation',
                'attr'  => [
                    'placeholder' => 'DWWM'
                ]
            ])
            ->add('startedAt', DateType::class, [
                'label'    => 'Date de début de la formation',
                'widget'   => 'single_text',
                'input'    => 'datetime_immutable',
                'required' => false
            ])
            ->add('finishedAt', DateType::class, [
                'label'    => 'Date de fin de la formation',
                'widget'   => 'single_text',
                'input'    => 'datetime_immutable',
                'required' => false
            ])
            ->add('ville', ChoiceType::class, [
                'label'    => 'Lieu de la formation',
                'choices'  => [
                    'TOURS'   => 'TOURS',
                    'ORLEANS' => 'ORLEANS'
                ],
                'required' => false
            ])
            ->add('referent', EntityType::class, [
                'label'        => 'Référent de la formation',
                'required'     => false,
                'class'        => User::class,
                'choice_label' => 'lastname'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Formation::class,
            ]
        );
    }
}
