<?php

namespace App\Entity;

use App\Repository\MesuresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MesuresRepository::class)]
class Mesures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'mesure', targetEntity: IngredientsByRecette::class)]
    private Collection $ingredientsByRecettes;

    public function __construct()
    {
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
            $ingredientsByRecette->setMesure($this);
        }

        return $this;
    }

    public function removeIngredientsByRecette(IngredientsByRecette $ingredientsByRecette): static
    {
        if ($this->ingredientsByRecettes->removeElement($ingredientsByRecette)) {
            // set the owning side to null (unless already changed)
            if ($ingredientsByRecette->getMesure() === $this) {
                $ingredientsByRecette->setMesure(null);
            }
        }

        return $this;
    }

    public function __tostring()
    {
        return $this->getTitle();
    }
}
