<?php

namespace App\Form;

use App\Entity\Recettes;
use App\Entity\Ingredients;
use App\Entity\IngredientsByRecette;
use App\Form\IngredientsByRecetteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            //->add('menus')
            ->add('ingredients', EntityType::class, [
                // looks for choices from this entity
                'class' => Ingredients::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'title',
            
                // used to render a select box, check boxes or radios
                 'multiple' => true,
                 'expanded' => true,
            ])
            

            ->add('ingredientsByRecettes', CollectionType::class, [
                'entry_type' => IngredientsByRecetteType::class,
                'allow_add' => true, // true si tu veux que l'utilisateur puisse en ajouter
                'allow_delete' => true, // true si tu veux que l'utilisateur puisse en supprimer
                'label' => 'Les ingrédients',
                'entry_options' => ['label' => false],
                'prototype' => true, //prototype : On veut qu’un prototype soit défini afin de pouvoir gérer la collection en javascript côté client.
                'by_reference' => false, //En passant cet attribut à false, on force Symfony à appeler le setter de l’entité.
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
        ]);
    }
}
