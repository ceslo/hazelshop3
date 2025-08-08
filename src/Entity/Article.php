<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext:[ 'groups'=>['read:collection']],
    operations:[   
        new Get,  
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ]
   
)]

class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[Groups(['read:collection'])]
    #[ORM\Column(length: 50)]
    private ?string $libelle_article = null;

    #[Groups(['read:collection'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_article = null;

    #[Groups(['read:collection'])]
    #[ORM\Column(nullable: true)]
    private ?int $qte_stock = null;

    #[Groups(['read:collection'])]
    #[ORM\Column (type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $prix_achat = null;

    #[Groups(['read:collection'])]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ref_fournisseur = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, DetailsCommande>
     */
    #[ORM\OneToMany(targetEntity: DetailsCommande::class, mappedBy: 'article')]
    private Collection $detailsCommandes;

   

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    /**
     * @var Collection<int, DetailsLivraison>
     */
    #[ORM\OneToMany(targetEntity: DetailsLivraison::class, mappedBy: 'article')]
    private Collection $detailsLivraisons;

    public function __construct()
    {
        $this->detailsCommandes = new ArrayCollection();
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

    public function getLibelleArticle(): ?string
    {
        return $this->libelle_article;
    }

    public function setLibelleArticle(string $libelle_article): static
    {
        $this->libelle_article = $libelle_article;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImgArticle(): ?string
    {
        return $this->img_article;
    }

    public function setImgArticle(?string $img_article): static
    {
        $this->img_article = $img_article;

        return $this;
    }

    public function getQteStock(): ?int
    {
        return $this->qte_stock;
    }

    public function setQteStock(?int $qte_stock): static
    {
        $this->qte_stock = $qte_stock;

        return $this;
    }

    public function getPrixAchat(): ?string
    {
        return $this->prix_achat;
    }

    public function setPrixAchat(string $prix_achat): static
    {
        $this->prix_achat = $prix_achat;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, DetailsCommande>
     */
    public function getDetailsCommandes(): Collection
    {
        return $this->detailsCommandes;
    }

    public function addDetailsCommande(DetailsCommande $detailsCommande): static
    {
        if (!$this->detailsCommandes->contains($detailsCommande)) {
            $this->detailsCommandes->add($detailsCommande);
            $detailsCommande->setArticle($this);
        }

        return $this;
    }

    public function removeDetailsCommande(DetailsCommande $detailsCommande): static
    {
        if ($this->detailsCommandes->removeElement($detailsCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailsCommande->getArticle() === $this) {
                $detailsCommande->setArticle(null);
            }
        }

        return $this;
    }

    public function getRefFournisseur(): ?string
    {
        return $this->ref_fournisseur;
    }

    public function setRefFournisseur(?string $ref_fournisseur): static
    {
        $this->ref_fournisseur = $ref_fournisseur;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

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
            $detailsLivraison->setArticle($this);
        }

        return $this;
    }

    public function removeDetailsLivraison(DetailsLivraison $detailsLivraison): static
    {
        if ($this->detailsLivraisons->removeElement($detailsLivraison)) {
            // set the owning side to null (unless already changed)
            if ($detailsLivraison->getArticle() === $this) {
                $detailsLivraison->setArticle(null);
            }
        }

        return $this;
    }
}
