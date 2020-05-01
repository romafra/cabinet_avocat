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

class EditRdvAvocatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('subject', TextType::class, [
            'disabled' => true,
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
                'label' => 'Gestion du rendez-vous',
                'choices' => [
                    'Je confirme le rendez-vous' => 'Confirmé par l\'avocat',
                    'Je propose un report du RDV' => 'Reporté par l\'avocat',
                    'Je propose un autre lieu de rendez-vous' => 'Lieu changé par l\'avocat',
                    'J\'annule le rendez-vous' => 'Annulé par l\'avocat'                  
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
