<?php

namespace App\Form;

use App\Entity\Recettes;
use App\Entity\Ingredients;
use App\Entity\RecettesCategorie;
use App\Entity\IngredientsByRecette;
use App\Form\IngredientsByRecetteType;
use Symfony\Component\Form\AbstractType;
use App\Repository\IngredientsRepository;
use App\Repository\RecettesCategorieRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')

            ->add('categorie')

            ->add('categorie', EntityType::class, [
                // looks for choices from this entity
                'class' => RecettesCategorie::class,
                'query_builder' => function(RecettesCategorieRepository $catégorie) { 
                    return $catégorie->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
                // uses the User.username property as the visible option string
                'choice_label' => 'title',
            
                // used to render a select box, check boxes or radios
                 'multiple' => false,
                 'expanded' => false,
            ])



            ->add('personnes')
            ->add('instructions')

            ->add('source')
            //->add('menus')
         

            ->add('file',FileType::class, [
                'mapped' => false,
                'required' => false
            ])

            ->add('ingredients', EntityType::class, [
                // looks for choices from this entity
                'class' => Ingredients::class,
                'query_builder' => function(IngredientsRepository $IngredientsRepository) { 
                    return $IngredientsRepository->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
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
                'entry_options' => ['label' => false],
                'prototype' => true, //prototype : On veut qu’un prototype soit défini afin de pouvoir gérer la collection en javascript côté client.
                'by_reference' => false, //En passant cet attribut à false, on force Symfony à appeler le setter de l’entité.
                'delete_empty' => true
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
