<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Form\IngredientsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IngredientsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\IngredientsCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/ingredients')]
class IngredientsController extends AbstractController
{
    #[Route('/', name: 'app_ingredients_index', methods: ['GET'])]
    public function index(Request $request, IngredientsRepository $ingredientsRepository,IngredientsCategorieRepository $ingredientsCategorieRepository): Response
    {
        $categorie=$request->get('categorie');
        if (isset($categorie))
       {

        if ($categorie != 0)
        {
            return $this->render('ingredients/index.html.twig', [
                //'ingredients' => $ingredientsRepository->findA[ll(),
               // 'ingredients' => $ingredientsRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
                'ingredients_categories' => $ingredientsCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
    
                'ingredients' => $ingredientsRepository->findBy(array('categorie' => $categorie),array('title' => 'ASC'),NULL,NULL),
    
            ]);

        }

        else
        {

            return $this->render('ingredients/index.html.twig', [
                //'ingredients' => $ingredientsRepository->findA[ll(),
               // 'ingredients' => $ingredientsRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
                'ingredients_categories' => $ingredientsCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
    
                'ingredients' => $ingredientsRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
    
            ]);
        }
       
        
    
       }

       else
       {
        return $this->render('ingredients/index.html.twig', [
            //'ingredients' => $ingredientsRepository->findA[ll(),
           // 'ingredients' => $ingredientsRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
            'ingredients_categories' => $ingredientsCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

            'ingredients' => $ingredientsRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

        ]);
       }

    
    }



    #[Route('/new', name: 'app_ingredients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ingredient = new Ingredients();
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ingredient->setMesure('');

            $entityManager->persist($ingredient);
            $entityManager->flush();
            $this->addFlash('success','Ingrédient ajouté');

            return $this->redirectToRoute('app_ingredients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingredients/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_show', methods: ['GET'])]
    public function show(Ingredients $ingredient): Response
    {
        return $this->render('ingredients/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ingredients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ingredients $ingredient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success','Ingrédient modifié');

            return $this->redirectToRoute('app_ingredients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingredients/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_delete', methods: ['POST'])]
    public function delete(Request $request, Ingredients $ingredient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ingredient);
            $entityManager->flush();
            $this->addFlash('warning','Ingrédient supprimée');

        }

        return $this->redirectToRoute('app_ingredients_index', [], Response::HTTP_SEE_OTHER);
    }
}
