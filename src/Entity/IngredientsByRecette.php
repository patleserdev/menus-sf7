<?php

namespace App\Entity;

use App\Repository\IngredientsByRecetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientsByRecetteRepository::class)]
class IngredientsByRecette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'ingredientsByRecettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredients $ingredient = null;

    #[ORM\ManyToOne(inversedBy: 'ingredientsByRecettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recettes $recette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIngredient(): ?Ingredients
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredients $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getRecette(): ?Recettes
    {
        return $this->recette;
    }

    public function setRecette(?Recettes $recette): static
    {
        $this->recette = $recette;

        return $this;
    }



}
