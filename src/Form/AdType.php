<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


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
            ->add('filename', FileType::class, [
                'label' => 'Photo ',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Merci de mettre une image',
                    ])
                ],
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
