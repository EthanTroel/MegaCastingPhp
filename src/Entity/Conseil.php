<?php

namespace App\Entity;

use App\Repository\ConseilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConseilRepository::class)]
#[ORM\Table(name: "Conseil")]
class Conseil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(name: "Libelle", length: 255)]
    private ?string $Libelle = null;

    #[ORM\Column(name: "Description", length: 255)]
    private ?string $Description = null;
    #[ORM\JoinTable(name: 'ConseilMetier')]
    #[ORM\JoinColumn(name: 'IdentifiantConseil', referencedColumnName: 'Identifiant')]
    #[ORM\InverseJoinColumn(name: 'IdentifiantMetier', referencedColumnName: 'Identifiant')]
    #[ORM\ManyToMany(targetEntity: Metier::class, inversedBy: 'conseils')]
    private Collection $Metiers;


    public function __construct()
    {
        $this->Metiers = new ArrayCollection();
        $this->metiers = new ArrayCollection();
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
     * @return Collection<int, Metier>
     */
    public function getMetiers(): Collection
    {
        return $this->Metiers;
    }

    public function addMetier(Metier $metier): self
    {
        if (!$this->Metiers->contains($metier)) {
            $this->Metiers->add($metier);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        $this->Metiers->removeElement($metier);

        return $this;
    }
}
