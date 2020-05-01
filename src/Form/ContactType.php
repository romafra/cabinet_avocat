<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('field_name')
            ->add('objet', ChoiceType::class, [
                'choices' => [
                'Demande d\'information' => 'Demande d\'information',
                'Demande de devis' => 'Demande de devis',
                'Demande d\'information sur les formations' => 'Demande d\'information sur les formations',
                'Autre' => 'Autre',

                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Objet * :'
            ])

            ->add('typededroit', ChoiceType::class, [
                'choices' => [
                'Droit Public' => 'Droit Public',
                'Droit des Affaires' => 'Droit des Affaires',
                'Droit Privé' => 'Droit Privé',
                'Autre' => 'Autres',

                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Type de Droit * :'
            ])

            ->add('NomPrenom',TextType::class,['label' => 'Nom Prenom * :'])
            ->add('Telephone',TextType::class,['label' => 'Téléphone * :'])
            ->add('email',EmailType::class, ['label' => 'email * :'])
            ->add('Message',TextareaType::class ,['label' => 'Votre message * :'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
