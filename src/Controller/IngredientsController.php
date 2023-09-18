<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Form\IngredientsType;
use App\Repository\IngredientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ingredients')]
class IngredientsController extends AbstractController
{
    #[Route('/', name: 'app_ingredients_index', methods: ['GET'])]
    public function index(IngredientsRepository $ingredientsRepository): Response
    {
        return $this->render('ingredients/index.html.twig', [
            'ingredients' => $ingredientsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ingredients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ingredient = new Ingredients();
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ingredient);
            $entityManager->flush();

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
        }

        return $this->redirectToRoute('app_ingredients_index', [], Response::HTTP_SEE_OTHER);
    }
}
