<?php

namespace App\Controller;

use App\Repository\RecettesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RecettesRepository $recettesRepository): Response
    {

                /** affiche une recette au hasard  **/
                $randomRecette = NULL;
                while($randomRecette == NULL)
                {
                    $NombreRecettes=count($recettesRepository->findAll());
                    $randomId=rand(1, $NombreRecettes);               
                    $randomRecette = $recettesRepository->find($randomId);
                }
                
                /** fin affiche une recette au hasard  **/


                
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'recettes' => $recettesRepository->findBy(array(),array('titre' => 'ASC'),NULL,NULL),
            'randomRecette' => $randomRecette,
        ]);
    }
}
