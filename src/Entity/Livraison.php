<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_expedition = null;

    #[ORM\Column(length: 50)]
    private ?string $mode_livraison = null;

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    /**
     * @var Collection<int, DetailsLivraison>
     */
    #[ORM\OneToMany(targetEntity: DetailsLivraison::class, mappedBy: 'livraison')]
    private Collection $detailsLivraisons;

    public function __construct()
    {
        $this->detailsLivraisons = new ArrayCollection();
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

    public function getDateExpedition(): ?\DateTimeInterface
    {
        return $this->date_expedition;
    }

    public function setDateExpedition(?\DateTimeInterface $date_expedition): static
    {
        $this->date_expedition = $date_expedition;

        return $this;
    }

    public function getModeLivraison(): ?string
    {
        return $this->mode_livraison;
    }

    public function setModeLivraison(string $mode_livraison): static
    {
        $this->mode_livraison = $mode_livraison;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * @return Collection<int, DetailsLivraison>
     */
    public function getDetailsLivraisons(): Collection
    {
        return $this->detailsLivraisons;
    }

    public function addDetailsLivraison(DetailsLivraison $detailsLivraison): static
    {
        if (!$this->detailsLivraisons->contains($detailsLivraison)) {
            $this->detailsLivraisons->add($detailsLivraison);
            $detailsLivraison->setLivraison($this);
        }

        return $this;
    }

    public function removeDetailsLivraison(DetailsLivraison $detailsLivraison): static
    {
        if ($this->detailsLivraisons->removeElement($detailsLivraison)) {
            // set the owning side to null (unless already changed)
            if ($detailsLivraison->getLivraison() === $this) {
                $detailsLivraison->setLivraison(null);
            }
        }

        return $this;
    }
}
