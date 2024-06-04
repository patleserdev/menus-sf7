<?php

namespace App\Controller;

use App\Entity\IngredientsCategorie;
use App\Form\IngredientsCategorieType;
use App\Repository\IngredientsCategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ingredients/categorie')]
class IngredientsCategorieController extends AbstractController
{
    #[Route('/', name: 'app_ingredients_categorie_index', methods: ['GET'])]
    public function index(IngredientsCategorieRepository $ingredientsCategorieRepository): Response
    {
        return $this->render('ingredients_categorie/index.html.twig', [
         //   'ingredients_categories' => $ingredientsCategorieRepository->findAll(),
            'ingredients_categories' => $ingredientsCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

        ]);
    }

    #[Route('/new', name: 'app_ingredients_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ingredientsCategorie = new IngredientsCategorie();
        $form = $this->createForm(IngredientsCategorieType::class, $ingredientsCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ingredientsCategorie);
            $entityManager->flush();
            $this->addFlash('success','Catégorie ajoutée');
            return $this->redirectToRoute('app_ingredients_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingredients_categorie/new.html.twig', [
            'ingredients_categorie' => $ingredientsCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_categorie_show', methods: ['GET'])]
    public function show(IngredientsCategorie $ingredientsCategorie): Response
    {
        return $this->render('ingredients_categorie/show.html.twig', [
            'ingredients_categorie' => $ingredientsCategorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ingredients_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IngredientsCategorie $ingredientsCategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IngredientsCategorieType::class, $ingredientsCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success','Catégorie modifiée');
            return $this->redirectToRoute('app_ingredients_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingredients_categorie/edit.html.twig', [
            'ingredients_categorie' => $ingredientsCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, IngredientsCategorie $ingredientsCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredientsCategorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ingredientsCategorie);
            $entityManager->flush();
            $this->addFlash('success','Catégorie supprimée');
        }
        else
        {
            $this->addFlash('warning','Catégorie non supprimée');
        }

        return $this->redirectToRoute('app_ingredients_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
