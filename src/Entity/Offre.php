<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Libelle = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateDeb = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $Reference = null;

    #[ORM\Column(length: 255)]
    private ?string $Localisation = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Agemin = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $AgeMax = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\ManyToMany(targetEntity: Sexe::class, mappedBy: 'Offres')]
    private Collection $sexes;

    #[ORM\ManyToMany(targetEntity: PartenaireDiffusion::class, mappedBy: 'Offres')]
    private Collection $partenaireDiffusions;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Client $Clients = null;

    #[ORM\ManyToOne(inversedBy: 'Offres')]
    private ?Metier $metier = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?TypeContrat $TypeContrats = null;

    public function __construct()
    {
        $this->sexes = new ArrayCollection();
        $this->partenaireDiffusions = new ArrayCollection();
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

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->DateDeb;
    }

    public function setDateDeb(\DateTimeInterface $DateDeb): self
    {
        $this->DateDeb = $DateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): self
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->Localisation;
    }

    public function setLocalisation(string $Localisation): self
    {
        $this->Localisation = $Localisation;

        return $this;
    }

    public function getAgemin(): ?int
    {
        return $this->Agemin;
    }

    public function setAgemin(int $Agemin): self
    {
        $this->Agemin = $Agemin;

        return $this;
    }

    public function getAgeMax(): ?int
    {
        return $this->AgeMax;
    }

    public function setAgeMax(int $AgeMax): self
    {
        $this->AgeMax = $AgeMax;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

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
     * @return Collection<int, Sexe>
     */
    public function getSexes(): Collection
    {
        return $this->sexes;
    }

    public function addSex(Sexe $sex): self
    {
        if (!$this->sexes->contains($sex)) {
            $this->sexes->add($sex);
            $sex->addOffre($this);
        }

        return $this;
    }

    public function removeSex(Sexe $sex): self
    {
        if ($this->sexes->removeElement($sex)) {
            $sex->removeOffre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PartenaireDiffusion>
     */
    public function getPartenaireDiffusions(): Collection
    {
        return $this->partenaireDiffusions;
    }

    public function addPartenaireDiffusion(PartenaireDiffusion $partenaireDiffusion): self
    {
        if (!$this->partenaireDiffusions->contains($partenaireDiffusion)) {
            $this->partenaireDiffusions->add($partenaireDiffusion);
            $partenaireDiffusion->addOffre($this);
        }

        return $this;
    }

    public function removePartenaireDiffusion(PartenaireDiffusion $partenaireDiffusion): self
    {
        if ($this->partenaireDiffusions->removeElement($partenaireDiffusion)) {
            $partenaireDiffusion->removeOffre($this);
        }

        return $this;
    }

    public function getClients(): ?Client
    {
        return $this->Clients;
    }

    public function setClients(?Client $Clients): self
    {
        $this->Clients = $Clients;

        return $this;
    }

    public function getMetier(): ?Metier
    {
        return $this->metier;
    }

    public function setMetier(?Metier $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    public function getTypeContrats(): ?TypeContrat
    {
        return $this->TypeContrats;
    }

    public function setTypeContrats(?TypeContrat $TypeContrats): self
    {
        $this->TypeContrats = $TypeContrats;

        return $this;
    }
}
