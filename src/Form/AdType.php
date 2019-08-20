<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {

        $builder
            ->add('titre',TextType::class,[
                "trim" => true,
                "label" => "Titre",
    ])
            ->add('categorie',EntityType::class,[

                'class' => Categorie::class,
                'choice_label' => function ($categorie){
                return $categorie->getLibelle();
                },
                "trim" => true,
                "label" => "Categorie",
            ])
            ->add('description',TextareaType::class,[
                "label" => "Description",
            ])
            ->add('ville',TextType::class,[
                "trim" => true,
                "label" => "Ville",
            ])
            ->add('cp',TextType::class,[
                "trim" => true,
                "label" => "Code postal",
            ])
            ->add('prix',MoneyType::class,[
                "trim" => true,
                "label" => "Prix en ",
            ])
            //->add('dateCreation')
             ->add('submit', SubmitType::class, [

                "label" => "Envoyer",]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
