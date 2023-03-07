<?php

namespace App\Entity;

use App\Repository\MetierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetierRepository::class)]
class Metier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\ManyToMany(targetEntity: Conseil::class, mappedBy: 'Metiers')]
    private Collection $conseils;

    #[ORM\ManyToOne(inversedBy: 'metiers')]
    private ?FicheMetier $FicheMetiers = null;

    #[ORM\OneToMany(mappedBy: 'metier', targetEntity: Offre::class)]
    private Collection $Offres;

    #[ORM\ManyToOne(inversedBy: 'metiers')]
    private ?DomaineMetier $DomaineMetiers = null;

    #[ORM\ManyToMany(targetEntity: Conseil::class, inversedBy: 'metiers')]
    private Collection $Conseils;

    public function __construct()
    {
        $this->conseils = new ArrayCollection();
        $this->Offres = new ArrayCollection();
        $this->Conseils = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Conseil>
     */
    public function getConseils(): Collection
    {
        return $this->conseils;
    }

    public function addConseil(Conseil $conseil): self
    {
        if (!$this->conseils->contains($conseil)) {
            $this->conseils->add($conseil);
            $conseil->addMetier($this);
        }

        return $this;
    }

    public function removeConseil(Conseil $conseil): self
    {
        if ($this->conseils->removeElement($conseil)) {
            $conseil->removeMetier($this);
        }

        return $this;
    }

    public function getFicheMetiers(): ?FicheMetier
    {
        return $this->FicheMetiers;
    }

    public function setFicheMetiers(?FicheMetier $FicheMetiers): self
    {
        $this->FicheMetiers = $FicheMetiers;

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
            $offre->setMetier($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->Offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getMetier() === $this) {
                $offre->setMetier(null);
            }
        }

        return $this;
    }

    public function getDomaineMetiers(): ?DomaineMetier
    {
        return $this->DomaineMetiers;
    }

    public function setDomaineMetiers(?DomaineMetier $DomaineMetiers): self
    {
        $this->DomaineMetiers = $DomaineMetiers;

        return $this;
    }
}
