<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $num_client = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?float $coef_client = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $forme_juridique = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $raison_sociale = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $siren = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $num_tva = null;

    #[ORM\Column(nullable: true)]
    private ?float $reduction_pro = null;

   

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'client')]
    private Collection $commandes;

    #[ORM\OneToOne(mappedBy: 'client', cascade: ['persist', 'remove'])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeClient $type_client = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    private ?utilisateur $commercial = null;

    /**
     * @var Collection<int, Adresse>
     */
    #[ORM\OneToMany(targetEntity: Adresse::class, mappedBy: 'client')]
    private Collection $adresses;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->adresses = new ArrayCollection();
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

    public function getNumClient(): ?string
    {
        return $this->num_client;
    }

    public function setNumClient(string $num_client): static
    {
        $this->num_client = $num_client;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCoefClient(): ?float
    {
        return $this->coef_client;
    }

    public function setCoefClient(float $coef_client): static
    {
        $this->coef_client = $coef_client;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->forme_juridique;
    }

    public function setFormeJuridique(?string $forme_juridique): static
    {
        $this->forme_juridique = $forme_juridique;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raison_sociale;
    }

    public function setRaisonSociale(?string $raison_sociale): static
    {
        $this->raison_sociale = $raison_sociale;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): static
    {
        $this->siren = $siren;

        return $this;
    }

    public function getNumTva(): ?string
    {
        return $this->num_tva;
    }

    public function setNumTva(?string $num_tva): static
    {
        $this->num_tva = $num_tva;

        return $this;
    }

    public function getReductionPro(): ?float
    {
        return $this->reduction_pro;
    }

    public function setReductionPro(?float $reduction_pro): static
    {
        $this->reduction_pro = $reduction_pro;

        return $this;
    }

    

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        // unset the owning side of the relation if necessary
        if ($utilisateur === null && $this->utilisateur !== null) {
            $this->utilisateur->setClient(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateur !== null && $utilisateur->getClient() !== $this) {
            $utilisateur->setClient($this);
        }

        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getTypeClient(): ?TypeClient
    {
        return $this->type_client;
    }

    public function setTypeClient(?TypeClient $type_client): static
    {
        $this->type_client = $type_client;

        return $this;
    }

    public function getCommercial(): ?utilisateur
    {
        return $this->commercial;
    }

    public function setCommercial(?utilisateur $commercial): static
    {
        $this->commercial = $commercial;

        return $this;
    }

    /**
     * @return Collection<int, Adresse>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresse $adress): static
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setClient($this);
        }

        return $this;
    }

    public function removeAdress(Adresse $adress): static
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getClient() === $this) {
                $adress->setClient(null);
            }
        }

        return $this;
    }
}
