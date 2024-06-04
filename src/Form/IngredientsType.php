<?php

namespace App\Form;

use App\Entity\Ingredients;
use App\Entity\IngredientsCategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\IngredientsCategorieRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class IngredientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
           
           

            ->add('categorie', EntityType::class, [
                // looks for choices from this entity
                'class' => IngredientsCategorie::class,
                'query_builder' => function(IngredientsCategorieRepository $catégorie) { 
                    return $catégorie->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
                // uses the User.username property as the visible option string
                'choice_label' => 'title',
            
                // used to render a select box, check boxes or radios
                 'multiple' => false,
                 'expanded' => false,
            ])


        
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredients::class,
        ]);
    }
}
