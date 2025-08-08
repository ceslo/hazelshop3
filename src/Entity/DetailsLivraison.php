<?php

namespace App\Entity;

use App\Repository\DetailsLivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsLivraisonRepository::class)]
class DetailsLivraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detailsLivraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'detailsLivraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Livraison $livraison = null;

    #[ORM\Column]
    private ?int $qte_livree = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): static
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getQteLivree(): ?int
    {
        return $this->qte_livree;
    }

    public function setQteLivree(int $qte_livree): static
    {
        $this->qte_livree = $qte_livree;

        return $this;
    }
}
