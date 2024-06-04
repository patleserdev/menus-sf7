<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Form\RecettesType;
use App\Entity\Ingredients;
use Gedmo\Sluggable\Util\Urlizer;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IngredientsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RecettesCategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/recettes')]
class RecettesController extends AbstractController
{
    #[Route('/', name: 'app_recettes_index', methods: ['GET'])]
    public function index(Request $request,RecettesRepository $recettesRepository,RecettesCategorieRepository $recettesCategorieRepository): Response
    {

        $categorie=$request->get('categorie');

        if (isset($categorie))
        {

            if ($categorie != 0)
            {
                return $this->render('recettes/index.html.twig', [
                    //'recettes' => $recettesRepository->findAll(),
                    'recettes' => $recettesRepository->findBy(array('categorie' => $categorie),array('titre' => 'ASC'),NULL,NULL),
                    'recettes_categories' => $recettesCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
    
                  
                ]);

            }

            else
            {

                return $this->render('recettes/index.html.twig', [
                    //'recettes' => $recettesRepository->findAll(),
                    'recettes' => $recettesRepository->findBy(array(),array('titre' => 'ASC'),NULL,NULL),
                    'recettes_categories' => $recettesCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),
    
                  
                ]);
    
    
            }
       
         
        }

        else
        {
            return $this->render('recettes/index.html.twig', [
                //'recettes' => $recettesRepository->findAll(),
                'recettes' => $recettesRepository->findBy(array(),array('titre' => 'ASC'),NULL,NULL),
                'recettes_categories' => $recettesCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

              
            ]);

        }
    }

    #[Route('/new', name: 'app_recettes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,IngredientsRepository $ingredientsRepository): Response
    {
        $recette = new Recettes();
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['file']->getData();

            if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';

            
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename);
           // dd($form);

           
           $recette->setFile($newFilename);
            }
           // var_dump($recette);
            //exit;
            $entityManager->persist($recette);
            $entityManager->flush();
            $this->addFlash('success','Recette ajoutée');

            return $this->redirectToRoute('app_recettes_index', [], Response::HTTP_SEE_OTHER);
        }

             return $this->render('recettes/new.html.twig', [
            'recette' => $recette,
            'form' => $form,
            //'ingredients' => $ingredientsRepository->findAll(),
            //'ingredients' => $ingredientsRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL)

        ]);
    }

    #[Route('/{id}', name: 'app_recettes_show', methods: ['GET'])]
    public function show(Recettes $recette): Response
    {
        return $this->render('recettes/show.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recettes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recettes $recette, EntityManagerInterface $entityManager,IngredientsRepository $ingredientsRepository): Response
    {
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

           
            $uploadedFile = $form['file']->getData();

            if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';

            
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename);
           // dd($form);

           $recette->setFile($newFilename);
            }

            $entityManager->flush();
            $this->addFlash('success','Recette modifiée');

            return $this->redirectToRoute('app_recettes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recettes/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
            //'ingredients' => $ingredientsRepository->findAll(),
            'ingredients' => $ingredientsRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

        ]);
    }

    #[Route('/{id}', name: 'app_recettes_delete', methods: ['POST'])]
    public function delete(Request $request, Recettes $recette, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recette);
            $entityManager->flush();
            $this->addFlash('success','Recette supprimée');

        }
        else
        {
            $this->addFlash('warning','Recette non supprimée');

        }
        return $this->redirectToRoute('app_recettes_index', [], Response::HTTP_SEE_OTHER);
    }
}
