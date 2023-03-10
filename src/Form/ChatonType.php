<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Chaton;
use App\Entity\Proprios;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChatonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Sterilise')
            ->add('Photo')
            ->add('Categorie', EntityType::class, [
                'class'=>Categorie::class, //choix de la classe liée
                'choice_label'=>"titre", //choix de ce qui sera affiché comme texte
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('Proprio', EntityType::class, [
                'class'=>Proprios::class,
                'choice_label'=>"prenom",
                'multiple'=>true, // Choix entre un ou plusieurs
                'expanded'=>true, // Liste déroulante (dégeu) ou checkbox/bouton radio
            ])
            ->add('OK', SubmitType::class, ["label"=>"OK"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chaton::class,

        ]);
    }
}
