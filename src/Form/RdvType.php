<?php

namespace App\Form;

use App\Entity\Rdv;
use App\Entity\Avocats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('avocat', EntityType::class, [
            'class' => Avocats::class, 
            'choice_label' => function (Avocats $avocat) {
                return "Maître " . $avocat->getFirstname() . ' ' . $avocat->getLastname();
        },
        'label' => 'Avocat *'
            
        ])
        ->add('date', DateType::class, [
            'label' => 'Date *',
            'format' => 'dd-MM-yyyy',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ]
        ])
        ->add('time', TimeType::class, [
            'label' => 'Horaire *'
        ])
        ->add('forname', TextType::class, [
            'label' => 'Nom du bénéficiaire *'
        ])
        ->add('subject', TextType::class, [
            'label' => 'Objet *'
        ])
        ->add('user_id', HiddenType::class)

        ->add('mode', ChoiceType::class, [
            'label' => 'Lieu *',
            'choices' => [
                'Au cabinet' => 'Au cabinet',
                'Par téléphone' => 'Par téléphone',
                'En visioconférence' => 'En visioconférence'
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
