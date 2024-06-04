<?php

namespace App\Controller;

use App\Entity\IngredientsByRecette;
use App\Form\IngredientsByRecetteType;
use App\Form\IngredientsByRecette1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\IngredientsByRecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ingredients/by/recette')]
class IngredientsByRecetteController extends AbstractController
{
    #[Route('/', name: 'app_ingredients_by_recette_index', methods: ['GET'])]
    public function index(IngredientsByRecetteRepository $ingredientsByRecetteRepository): Response
    {
        return $this->render('ingredients_by_recette/index.html.twig', [
            //'ingredients_by_recettes' => $ingredientsByRecetteRepository->findAll(),
            'ingredients_by_recettes' => $ingredientsByRecetteRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

        ]);
    }

    #[Route('/new', name: 'app_ingredients_by_recette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ingredientsByRecette = new IngredientsByRecette();
        $form = $this->createForm(IngredientsByRecetteType::class, $ingredientsByRecette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ingredientsByRecette);
            $entityManager->flush();

            $this->addFlash('success','Ingrédients ajoutés au menu');

            return $this->redirectToRoute('app_ingredients_by_recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingredients_by_recette/new.html.twig', [
            'ingredients_by_recette' => $ingredientsByRecette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_by_recette_show', methods: ['GET'])]
    public function show(IngredientsByRecette $ingredientsByRecette): Response
    {
        return $this->render('ingredients_by_recette/show.html.twig', [
            'ingredients_by_recette' => $ingredientsByRecette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ingredients_by_recette_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IngredientsByRecette $ingredientsByRecette, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IngredientsByRecetteType::class, $ingredientsByRecette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success','Ingrédients modifiés');
            return $this->redirectToRoute('app_ingredients_by_recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingredients_by_recette/edit.html.twig', [
            'ingredients_by_recette' => $ingredientsByRecette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_by_recette_delete', methods: ['POST'])]
    public function delete(Request $request, IngredientsByRecette $ingredientsByRecette, EntityManagerInterface $entityManager): Response
    {

        $ingredientsByRecette->getId();
        if ($this->isCsrfTokenValid('delete'.$ingredientsByRecette->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ingredientsByRecette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ingredients_by_recette_index', [], Response::HTTP_SEE_OTHER);
    }
}
