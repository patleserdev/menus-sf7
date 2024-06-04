<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Entity\Menus;
use App\Form\MenusType;
use App\Message\MenusPDFMessage;
use App\Entity\RecettesCategorie;
use App\Repository\MenusRepository;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RecettesCategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\IngredientsCategorieRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/menus')]
class MenusController extends AbstractController
{
    #[Route('/', name: 'app_menus_index', methods: ['GET'])]
    public function index(MenusRepository $menusRepository): Response
    {
        return $this->render('menus/index.html.twig', [
            //'menuses' => $menusRepository->findAll(),
            'menuses' => $menusRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

        ]);
    }


    #[Route('/{id}/list', name: 'app_menus_list', methods: ['GET', 'POST'])]
    public function list($id,Menus $menu, MenusRepository $MenusRepository ,UrlGeneratorInterface $urlgenerator): Response
    {
     
        //$recettes=$menu->getRecettes();

        // trouver tous les ingrédients des recettes de ce menu
            // je récupère les menus en manuel , je transformerai surement en dql
            // SELECT recettes.id FROM recettes JOIN menus_recettes ON recettes.id = menus_recettes.recettes_id JOIN menus ON menus.id = 1;
            // puis je fais un WHERE IN ingredients join la table recettes ingredients
            // SELECT ingredients.id, ingredients.title FROM ingredients JOIN recettes ON recettes.id = 1 JOIN ingredients_by_recette ON ingredients_by_recette.ingredient_id = ingredients.id AND ingredients_by_recette.recette_id = recettes.id;
        // pouvoir additionner les ingrédients pour avoir une liste unique qui contient le total de chaque ingrédient

        //SELECT ingredients.id, ingredients.title ,recettes.titre FROM ingredients JOIN recettes ON recettes.id IN (SELECT recettes.id FROM recettes JOIN menus_recettes ON recettes.id = menus_recettes.recettes_id JOIN menus ON menus.id = 1) JOIN ingredients_by_recette ON ingredients_by_recette.ingredient_id = ingredients.id AND ingredients_by_recette.recette_id = recettes.id ORDER BY ingredients.id;
       // $recettes=$MenusRepository->getalltheingredientsofthemenu($menu);
    
        return $this->render('menus/list.html.twig', [
            'menu' => $menu,
           // 'recettes' => $recettes,
        ]);
    }

    #[Route('/{id}/print', name: 'app_menus_print', methods: ['GET', 'POST'])]
    public function print($id,Menus $menu, MenusRepository $MenusRepository,IngredientsCategorieRepository $ingredientsCategorieRepository): Response
    {
     
        //$recettes=$menu->getRecettes();

        // trouver tous les ingrédients des recettes de ce menu
            // je récupère les menus en manuel , je transformerai surement en dql
            // SELECT recettes.id FROM recettes JOIN menus_recettes ON recettes.id = menus_recettes.recettes_id JOIN menus ON menus.id = 1;
            // puis je fais un WHERE IN ingredients join la table recettes ingredients
            // SELECT ingredients.id, ingredients.title FROM ingredients JOIN recettes ON recettes.id = 1 JOIN ingredients_by_recette ON ingredients_by_recette.ingredient_id = ingredients.id AND ingredients_by_recette.recette_id = recettes.id;
        // pouvoir additionner les ingrédients pour avoir une liste unique qui contient le total de chaque ingrédient

        //SELECT ingredients.id, ingredients.title ,recettes.titre FROM ingredients JOIN recettes ON recettes.id IN (SELECT recettes.id FROM recettes JOIN menus_recettes ON recettes.id = menus_recettes.recettes_id JOIN menus ON menus.id = 1) JOIN ingredients_by_recette ON ingredients_by_recette.ingredient_id = ingredients.id AND ingredients_by_recette.recette_id = recettes.id ORDER BY ingredients.id;
       $ingredients=$MenusRepository->getalltheingredientsofthemenu($menu->getId());

       // j'ai mes ingrédients au complet pour tout le menu
       // maintenant il faut que je fasse la somme de ces ingrédients si la mesure est identique.
       // je crée un nouveau tableau
       // je vérifie s'il existe une ligne de ce tableau qui contient déja le même id et la même mesure
       // s'il existe j'ajoute la nouvelle valeur à celle existante, sinon je crée une ligne

        $newarray=[];

       for($i=0 ; $i < count($ingredients) ;$i++)
       {
    
        foreach($ingredients as $ingredient)
        {
           

            if ($ingredient['id'] == $i)
            {
                
                
              
                    $newarray[]=["id" => $ingredient['id'],
                    "ingredient" => $ingredient['ingredient'],
                    "quantity" => $ingredient['total'],
                    "mesure" => $ingredient['mesure'],
                    "mesure_id" => $ingredient['mesure_id'],
                    "categorie" => $ingredient['categorie']
                    ]
                    ;
                
               
           
            } 
        }

       }
       //dd($newarray);

        return $this->render('menus/print.html.twig', [
            'menu' => $menu,
           'ingredients' => $newarray,
           'ingredients_categories' => $ingredientsCategorieRepository->findBy(array(),array('title' => 'ASC'),NULL,NULL),

        ]);
    }

    #[Route('/new', name: 'app_menus_new', methods: ['GET', 'POST'])] 
    public function new(Request $request, EntityManagerInterface $entityManager,
    RecettesRepository $recettesRepository,RecettesCategorieRepository $recettesCategorieRepository): Response
    {
        $menu = new Menus();
        $form = $this->createForm(MenusType::class, $menu);
        $form->handleRequest($request);

       

        if ($form->isSubmitted() && $form->isValid()) 

        {
            $entityManager->persist($menu);
            $entityManager->flush();

            $this->addFlash('success','Menu créé');

            return $this->redirectToRoute('app_menus_index', [], Response::HTTP_SEE_OTHER);
        }

        $recettes=$recettesCategorieRepository->findBy(array(),array('id' => 'ASC'),NULL,NULL);

        

        return $this->render('menus/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
            'recettes' => $recettesRepository->findBy(array(),array('titre' => 'ASC'),NULL,NULL),

            'recettescategories' => $recettes
        ]);
    }

    #[Route('/{id}/generate', name: 'app_menus_generate', methods: ['GET', 'POST'])] 
    public function generate($id,Menus $menu,
    MessageBusInterface $messageBus,
    UrlGeneratorInterface $urlGenerator,
    RecettesCategorieRepository $recettesCategorieRepository): Response
    {
        
        $recettes=$recettesCategorieRepository->findBy(array(),array('id' => 'ASC'),NULL,NULL);

        $url=$urlGenerator->generate('app_menus_print',['id' => $menu->getId()] , UrlGeneratorInterface::ABSOLUTE_URL);

        $messageBus->dispatch(new MenusPDFMessage($menu->getId(),$url));

        
        $this->addFlash('success','Pdf généré');

        return $this->redirectToRoute('app_menus_list', ['id' => $id], Response::HTTP_SEE_OTHER);

        /***
         * 
         * symfony console messenger:consume async -vv
         */
    }


    #[Route('/{id}', name: 'app_menus_show', methods: ['GET'])]
    public function show(Menus $menu): Response
    {
        return $this->render('menus/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_menus_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menus $menu, EntityManagerInterface $entityManager,
    RecettesCategorieRepository $recettesCategorieRepository,
    RecettesRepository $recettesRepository
    ): Response
    {
        $form = $this->createForm(MenusType::class, $menu);
        $form->handleRequest($request);

       
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success','Menu modifié');

            return $this->redirectToRoute('app_menus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menus/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
            'recettes' => $recettesRepository->findBy(array(),array('titre' => 'ASC'),NULL,NULL),
            'recettescategories' => $recettesCategorieRepository->findBy(array(),array('id' => 'ASC'),NULL,NULL),
        ]);
    }

    #[Route('/{id}', name: 'app_menus_delete', methods: ['POST'])]
    public function delete(Request $request, Menus $menu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($menu);
            $entityManager->flush();

            $this->addFlash('success','Menu supprimé');
        }

        else
        {
            $this->addFlash('warning','Menu non supprimé');
        }

        return $this->redirectToRoute('app_menus_index', [], Response::HTTP_SEE_OTHER);
    }
}
