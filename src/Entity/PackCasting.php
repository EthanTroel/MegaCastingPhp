<?php

namespace App\Entity;

use App\Repository\PackCastingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackCastingRepository::class)]
#[ORM\Table(name: "PackCasting")]
class PackCasting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'Identifiant')]
    private ?int $id = null;

    #[ORM\Column(name: "Libelle", length: 255)]
    private ?string $Libelle = null;

    #[ORM\Column(name: "NombreOffres", type: Types::SMALLINT)]
    private ?int $NombreOffre = null;

    #[ORM\Column(name: "PrixPack", type: Types::SMALLINT)]
    private ?int $PrixPack = null;

    #[ORM\OneToMany(mappedBy: 'packCasting', targetEntity: Client::class)]
    private Collection $Clients;

    public function __construct()
    {
        $this->Clients = new ArrayCollection();
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

    public function getNombreOffre(): ?int
    {
        return $this->NombreOffre;
    }

    public function setNombreOffre(int $NombreOffre): self
    {
        $this->NombreOffre = $NombreOffre;

        return $this;
    }

    public function getPrixPack(): ?int
    {
        return $this->PrixPack;
    }

    public function setPrixPack(int $PrixPack): self
    {
        $this->PrixPack = $PrixPack;

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->Clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->Clients->contains($client)) {
            $this->Clients->add($client);
            $client->setPackCasting($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->Clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getPackCasting() === $this) {
                $client->setPackCasting(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
