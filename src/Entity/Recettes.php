<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecettesRepository::class)]
class Recettes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Ingredients::class, inversedBy: 'recettes')]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Menus::class, mappedBy: 'recettes')]
    private Collection $menuses;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: IngredientsByRecette::class)]
    private Collection $ingredientsByRecettes;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->menuses = new ArrayCollection();
        $this->ingredientsByRecettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

   /**
     * @return Collection<int, ingredients>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(ingredients $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(ingredients $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }


    public function __tostring()
    {
        return $this->getTitre();
    }

    /**
     * @return Collection<int, Menus>
     */
    public function getMenuses(): Collection
    {
        return $this->menuses;
    }

    public function addMenus(Menus $menus): static
    {
        if (!$this->menuses->contains($menus)) {
            $this->menuses->add($menus);
            $menus->addRecettes($this);
        }

        return $this;
    }

    public function removeMenus(Menus $menus): static
    {
        if ($this->menuses->removeElement($menus)) {
            $menus->removeRecettes($this);
        }

        return $this;
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
            $ingredientsByRecette->setRecette($this);
        }

        return $this;
    }

    public function removeIngredientsByRecette(IngredientsByRecette $ingredientsByRecette): static
    {
        if ($this->ingredientsByRecettes->removeElement($ingredientsByRecette)) {
            // set the owning side to null (unless already changed)
            if ($ingredientsByRecette->getRecette() === $this) {
                $ingredientsByRecette->setRecette(null);
            }
        }

        return $this;
    }
}
