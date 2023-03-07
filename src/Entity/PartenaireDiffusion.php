<?php

namespace App\Entity;

use App\Repository\PartenaireDiffusionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartenaireDiffusionRepository::class)]
class PartenaireDiffusion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Tel = null;

    #[ORM\Column(length: 255)]
    private ?string $Mail = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'partenaireDiffusions')]
    private Collection $Offres;

    public function __construct()
    {
        $this->Offres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTel(): ?string
    {
        return $this->Tel;
    }

    public function setTel(string $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

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
