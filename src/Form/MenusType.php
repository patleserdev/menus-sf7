<?php

namespace App\Form;

use App\Entity\Menus;
use App\Entity\Recettes;
use App\Repository\RecettesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class MenusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
           // ->add('recettes')

            //->add('recettes', CollectionType::class);

            ->add('recettes', EntityType::class, [
                'label'=> false,
                'required' => false,
                // looks for choices from this entity
                'class' => Recettes::class,
                'query_builder' => function(RecettesRepository $RecettesRepository) { 
                    return $RecettesRepository->createQueryBuilder('u')->orderBy('u.titre', 'ASC');
                },
                // uses the User.username property as the visible option string
                'choice_label' => 'titre',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                 'expanded' => true,
            ]);

          
           


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menus::class,
        ]);
    }
}
