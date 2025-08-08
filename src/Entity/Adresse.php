<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]

class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle_adresse = null;

    #[ORM\Column(length: 50)]
    private ?string $numero = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $complement_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $voie = null;

    #[ORM\Column(length: 10)]
    private ?string $cp = null;

    #[ORM\Column(length: 60)]
    private ?string $ville = null;

    #[ORM\Column(length: 50)]
    private ?string $pays = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'adresse_livraison')]
    private Collection $commandes_livrees;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'adresse_facturation')]
    private Collection $commandes_facturees;

    #[ORM\ManyToOne(inversedBy: 'adresses')]
    private ?Client $client = null;

    public function __construct()
    {
        $this->commandes_livrees = new ArrayCollection();
        $this->commandes_facturees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLibelleAdresse(): ?string
    {
        return $this->libelle_adresse;
    }

    public function setLibelleAdresse(string $libelle_adresse): static
    {
        $this->libelle_adresse = $libelle_adresse;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complement_adresse;
    }

    public function setComplementAdresse(?string $complement_adresse): static
    {
        $this->complement_adresse = $complement_adresse;

        return $this;
    }

    public function getVoie(): ?string
    {
        return $this->voie;
    }

    public function setVoie(string $voie): static
    {
        $this->voie = $voie;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandesLivrees(): Collection
    {
        return $this->commandes_livrees;
    }

    public function addCommandesLivree(Commande $commandesLivree): static
    {
        if (!$this->commandes_livrees->contains($commandesLivree)) {
            $this->commandes_livrees->add($commandesLivree);
            $commandesLivree->setAdresseLivraison($this);
        }

        return $this;
    }

    public function removeCommandesLivree(Commande $commandesLivree): static
    {
        if ($this->commandes_livrees->removeElement($commandesLivree)) {
            // set the owning side to null (unless already changed)
            if ($commandesLivree->getAdresseLivraison() === $this) {
                $commandesLivree->setAdresseLivraison(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandesFacturees(): Collection
    {
        return $this->commandes_facturees;
    }

    public function addCommandesFacturee(Commande $commandesFacturee): static
    {
        if (!$this->commandes_facturees->contains($commandesFacturee)) {
            $this->commandes_facturees->add($commandesFacturee);
            $commandesFacturee->setAdresseFacturation($this);
        }

        return $this;
    }

    public function removeCommandesFacturee(Commande $commandesFacturee): static
    {
        if ($this->commandes_facturees->removeElement($commandesFacturee)) {
            // set the owning side to null (unless already changed)
            if ($commandesFacturee->getAdresseFacturation() === $this) {
                $commandesFacturee->setAdresseFacturation(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
