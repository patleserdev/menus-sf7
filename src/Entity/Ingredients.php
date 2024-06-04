<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\Query\Expr\OrderBy;
use App\Repository\IngredientsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: IngredientsRepository::class)]

class Ingredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $mesure = null;

    #[ORM\ManyToMany(targetEntity: Recettes::class, mappedBy: 'ingredients')]
    private Collection $recettes;

    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: IngredientsByRecette::class)]
 
    private Collection $ingredientsByRecettes;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    #[ORM\OrderBy(["title" => "ASC"])]

    private ?IngredientsCategorie $categorie = null;

  

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
        $this->ingredientsByRecettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMesure(): ?string
    {
        return $this->mesure;
    }

    public function setMesure(string $mesure): static
    {
        $this->mesure = $mesure;

        return $this;
    }

    /**
     * @return Collection<int, Recettes>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recettes $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->addIngredient($this);
        }

        return $this;
    }

    public function removeRecette(Recettes $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeIngredient($this);
        }

        return $this;
    }

    public function __tostring()
    {
        return $this->getTitle();
    }

    /**
     * @return Collection<int, IngredientsByRecette>
     */
    public function getIngredientsByRecettes(): Collection
    {
        return $this->ingredientsByRecettes;
    }

    public function addIngredientsByRecette(IngredientsByRecette $ingredientsByRecette): static
    {
        if (!$this->ingredientsByRecettes->contains($ingredientsByRecette)) {
            $this->ingredientsByRecettes->add($ingredientsByRecette);
            $ingredientsByRecette->setIngredient($this);
        }

        return $this;
    }

    public function removeIngredientsByRecette(IngredientsByRecette $ingredientsByRecette): static
    {
        if ($this->ingredientsByRecettes->removeElement($ingredientsByRecette)) {
            // set the owning side to null (unless already changed)
            if ($ingredientsByRecette->getIngredient() === $this) {
                $ingredientsByRecette->setIngredient(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?IngredientsCategorie
    {
        return $this->categorie;
    }

    public function setCategorie(?IngredientsCategorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
   
    
}
