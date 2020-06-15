<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="category")
     */
    private $annonce;

    public function __construct()
    {
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonce(): Collection
    {
        return $this->annonce;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonce->contains($annonce)) {
            $this->annonce[] = $annonce;
            $annonce->setCategory($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonce->contains($annonce)) {
            $this->annonce->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getCategory() === $this) {
                $annonce->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
