<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: "Client")]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(name: "Nom", length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(name: "Tel", length: 10)]
    private ?string $Tel = null;

    #[ORM\Column(name: "Mail", length: 255)]
    private ?string $Mail = null;

    #[ORM\Column(name: "Password", length: 255)]
    private ?string $Password = null;

    #[ORM\Column(name: "Url", length: 255)]
    private ?string $Url = null;

    #[ORM\Column(name: "Siret", length: 255)]
    private ?string $Siret = null;

    #[ORM\Column(name: "Login", length: 255)]
    private ?string $Login = null;

    #[ORM\Column(name: "Ville", length: 255)]
    private ?string $Ville = null;

    #[ORM\Column(name: "NombreOffresRestantes")]
    private ?int $NombreOffreRestantes = null;

    #[ORM\ManyToOne(inversedBy: 'Clients')]
    #[ORM\JoinColumn(name: 'IdentifiantPackCasting', referencedColumnName: 'Identifiant', nullable: false)]
    private ?PackCasting $packCasting = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: PackCasting::class)]
    private Collection $PackCastings;

    #[ORM\OneToMany(mappedBy: 'Clients', targetEntity: Offre::class)]
    private Collection $offres;

    public function __construct()
    {
        $this->PackCastings = new ArrayCollection();
        $this->offres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->Url;
    }

    public function setUrl(string $Url): self
    {
        $this->Url = $Url;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->Siret;
    }

    public function setSiret(string $Siret): self
    {
        $this->Siret = $Siret;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->Login;
    }

    public function setLogin(string $Login): self
    {
        $this->Login = $Login;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getNombreOffreRestantes(): ?int
    {
        return $this->NombreOffreRestantes;
    }

    public function setNombreOffreRestantes(int $NombreOffreRestantes): self
    {
        $this->NombreOffreRestantes = $NombreOffreRestantes;

        return $this;
    }

    public function getPackCasting(): ?PackCasting
    {
        return $this->packCasting;
    }

    public function setPackCasting(?PackCasting $packCasting): self
    {
        $this->packCasting = $packCasting;

        return $this;
    }

    /**
     * @return Collection<int, PackCasting>
     */
    public function getPackCastings(): Collection
    {
        return $this->PackCastings;
    }

    public function addPackCasting(PackCasting $packCasting): self
    {
        if (!$this->PackCastings->contains($packCasting)) {
            $this->PackCastings->add($packCasting);
            $packCasting->setClient($this);
        }

        return $this;
    }

    public function removePackCasting(PackCasting $packCasting): self
    {
        if ($this->PackCastings->removeElement($packCasting)) {
            // set the owning side to null (unless already changed)
            if ($packCasting->getClient() === $this) {
                $packCasting->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setClients($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getClients() === $this) {
                $offre->setClients(null);
            }
        }




        return $this;
    }
    public function __toString(): string
    {
        return $this->id;
    }
}
