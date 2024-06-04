# menus

Objectifs
    OK Pouvoir ajouter des ingrédients 
    OK Classer les ingrédients par catégories 
    OK Filtrer les ingrédients par catégories en ajax 
        
    OK Pouvoir ajouter des recettes contenant des ingrédients 
    OK Classer les recettes par catégories 
    OK Filter les recettes par catégories en ajax 
    OK Ajouter/Afficher des images dans les recettes 
        
    Pouvoir ajouter des menus contenant des recettes 
    
    Nouveaux objectifs
    Dans le formulaire de recettes, filtrer l'affichage des ingrédients par catégories
    OK Gérer les multiples de quantités
    Indiquer dans la recette pour combien et en front multiplier ou diviser    
    Générer une liste de menus pour la semaine 
    En déduire une liste d'ingrédients gérés par nombre de personnes
    OK Générer la liste de courses en pdf
    Envoyer la liste de course par mail à X 
    Intégrer le menu joker
    Dans les menus, pouvoir préciser la quantité de tel ou tel ingrédient basé sur les mesures des ingrédients 
    envoyer un sms avec la liste de courses
    

    Bonus
    OK Carousel OWL sur la page d'accueil 
    OK La recette du moment (random) sur la page d'accueil 

    

    Contraintes
    Problèmes d'ordre des ingrédients ou recettes dans les formulaires 
    

12/03/2024 
- ajout de messages flash dans le base.html.twig
- activation sur messenger pour générer menus en pdf
- lancer docker desktop , 
- déclencher un docker run --rm -p 3000:3000 gotenberg/gotenberg:8   puis    symfony console messenger:consume async -vv
localhost:3000/health pour voir l'état de gotenberg

docker run --rm -p 3000:3000 gotenberg/gotenberg:8 > logs.txt
docker run --rm -p 3000:3000 gotenberg/gotenberg:8   

  

03/04 
-j'ai des problèmes pour que gotenberg me fasse la convert pdf
pourtant docker et gotenberg ont bien la bonne route, le messenger passe bien l'info, je ne vois pas ...
j'ai essayé avec d'autres pages sans succès, ce n'est pas une histoire d'authentification ...
j'essaie d'une autre manière

04/04 
-passage sur knpSnappyPdf - génération pdf de base ok , améliorations à apporter, contrôle si fichier existe , visuel ... etc

05/04 
- correction visuel simplifié du pdf généré avec son propre base.twig sans navbar,etc... 
