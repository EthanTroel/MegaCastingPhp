<?php

namespace App\Entity;

use App\Repository\SexeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SexeRepository::class)]
class Sexe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Libelle = null;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'sexes')]
    private Collection $Offres;

    public function __construct()
    {
        $this->Offres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->Offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->Offres->contains($offre)) {
            $this->Offres->add($offre);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        $this->Offres->removeElement($offre);

        return $this;
    }
}
