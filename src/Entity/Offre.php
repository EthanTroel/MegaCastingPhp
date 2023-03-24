<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use http\Env\Request;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
#[ORM\Table(name: "Offre")]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(name: "Libelle", length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(name: "DateDebut", type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateDeb = null;

    #[ORM\Column(name: "DateFin", type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateFin = null;

    #[ORM\Column(name: "Reference", length: 255)]
    private ?string $Reference = null;

    #[ORM\Column(name: "Localisation", length: 255)]
    private ?string $Localisation = null;

    #[ORM\Column(name: "AgeMin", type: Types::SMALLINT)]
    private ?int $Agemin = null;

    #[ORM\Column(name: "AgeMax", type: Types::SMALLINT)]
    private ?int $AgeMax = null;

    #[ORM\Column(name: "Date", type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(name: "Description", length: 255)]
    private ?string $description = null;
    #[ORM\JoinTable(name: 'OffreSexe')]
    #[ORM\JoinColumn(name: 'IdentifiantOffre', referencedColumnName: 'Identifiant')]
    #[ORM\InverseJoinColumn(name: 'IdentifiantSexe', referencedColumnName: 'Identifiant')]
    #[ORM\ManyToMany(targetEntity: Sexe::class, mappedBy: 'Offres')]
    private Collection $sexes;

    #[ORM\ManyToMany(targetEntity: PartenaireDiffusion::class, mappedBy: 'Offres')]
    private Collection $partenaireDiffusions;



    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(name: 'IdentifiantClient', referencedColumnName: 'Identifiant', nullable: false)]
    private ?Client $Clients = null;


   #[ORM\ManyToOne(inversedBy: 'Offres')]
   #[ORM\JoinColumn(name: 'IdentifiantMetier', referencedColumnName: 'Identifiant', nullable: false)]
   private ?Metier $metier = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(name: 'IdentifiantTypeContrat', referencedColumnName: 'Identifiant', nullable: false)]
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
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
