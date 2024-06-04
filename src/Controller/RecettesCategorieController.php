<?php

namespace App\Controller;

use App\Entity\RecettesCategorie;
use App\Form\RecettesCategorieType;
use App\Repository\RecettesCategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recettes/categorie')]
class RecettesCategorieController extends AbstractController
{
    #[Route('/', name: 'app_recettes_categorie_index', methods: ['GET'])]
    public function index(RecettesCategorieRepository $recettesCategorieRepository): Response
    {
        return $this->render('recettes_categorie/index.html.twig', [
           // 'recettes_categories' => $recettesCategorieRepository->findAll(),
            'recettes_categories' => $recettesCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

        ]);
    }

    #[Route('/new', name: 'app_recettes_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recettesCategorie = new RecettesCategorie();
        $form = $this->createForm(RecettesCategorieType::class, $recettesCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recettesCategorie);
            $entityManager->flush();
            $this->addFlash('success','Catégorie ajoutée');

            return $this->redirectToRoute('app_recettes_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recettes_categorie/new.html.twig', [
            'recettes_categorie' => $recettesCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recettes_categorie_show', methods: ['GET'])]
    public function show(RecettesCategorie $recettesCategorie): Response
    {
        return $this->render('recettes_categorie/show.html.twig', [
            'recettes_categorie' => $recettesCategorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recettes_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecettesCategorie $recettesCategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecettesCategorieType::class, $recettesCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success','Catégorie modifiée');

            return $this->redirectToRoute('app_recettes_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recettes_categorie/edit.html.twig', [
            'recettes_categorie' => $recettesCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recettes_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, RecettesCategorie $recettesCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recettesCategorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recettesCategorie);
            $entityManager->flush();
            $this->addFlash('success','Catégorie supprimée');

        }
        else
        {
            $this->addFlash('warning','Catégorie non supprimée');

        }
        return $this->redirectToRoute('app_recettes_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
