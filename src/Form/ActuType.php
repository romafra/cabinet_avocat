<?php

namespace App\Form;

use App\Entity\Actu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre *'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Contenu *'
            ])
            ->add('imageurl', TextType::class, [
                'attr' => ['placeholder' => 'ex. : http://liendelimage.fr'],
                'label' => 'Lien de la photo ',
                'help' => 'Info : L\'image doit être hébergée en ligne. (Taille requise : 250px X 250px)',
                'required' => false
            ])
            ->add('textalt', TextType::class, [
                'label' => 'Description de la photo',
                'help' => 'Info : La description de la photo est importante. Elle permet d\'améliorer le référencement du site',
                'required' => false
            ])
            ->add('link', TextType::class, [
                'attr' => ['placeholder' => 'ex. : http://lienverslarticle.fr'],
                'label' => 'Lien vers l\'article en ligne',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actu::class,
        ]);
    }
}
