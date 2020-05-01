<?php

namespace App\Form;

use App\Entity\Rdv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditRdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('subject', TextType::class, [
            'label' => 'Motif'
        ])
            ->add('date', DateType::class, [
                'format' => 'dd-MM-yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('time', TimeType::class, [
                'label' => 'Heure'
            ])

            ->add('user_id', HiddenType::class)
            
            ->add('mode', ChoiceType::class, [
                'label' => 'Lieu',
                'choices' => [
                    'Au cabinet' => 'Au cabinet',
                    'Par téléphone' => 'Par téléphone',
                    'En visioconférence' => 'En visioconférence'
                    ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Pourquoi modifiez-vous le rendez-vous ?',
                'choices' => [
                    'Je reporte le rendez-vous' => 'Reporté par le client',
                    'J\'annule le rendez-vous' => 'Annulé par le client',
                    'Je change le lieu du rendez-vous' => 'Lieu changé par le client',                    
                    ],
                'expanded' => false,
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
