<?php

namespace App\Controller;

use App\Entity\Mesures;
use App\Form\MesuresType;
use App\Repository\MesuresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mesures')]
class MesuresController extends AbstractController
{
    #[Route('/', name: 'app_mesures_index', methods: ['GET'])]
    public function index(MesuresRepository $mesuresRepository): Response
    {
        return $this->render('mesures/index.html.twig', [
            'mesures' => $mesuresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mesures_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mesure = new Mesures();
        $form = $this->createForm(MesuresType::class, $mesure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mesure);
            $entityManager->flush();
            $this->addFlash('success','Mesure ajoutée');

            return $this->redirectToRoute('app_mesures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mesures/new.html.twig', [
            'mesure' => $mesure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mesures_show', methods: ['GET'])]
    public function show(Mesures $mesure): Response
    {
        return $this->render('mesures/show.html.twig', [
            'mesure' => $mesure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mesures_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mesures $mesure, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MesuresType::class, $mesure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success','Mesure modifiée');

            return $this->redirectToRoute('app_mesures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mesures/edit.html.twig', [
            'mesure' => $mesure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mesures_delete', methods: ['POST'])]
    public function delete(Request $request, Mesures $mesure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mesure->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mesure);
            $entityManager->flush();
            $this->addFlash('success','Mesure supprimée');

        }
        else
        {
            $this->addFlash('warning','Mesure non supprimée');

        }

        return $this->redirectToRoute('app_mesures_index', [], Response::HTTP_SEE_OTHER);
    }
}
