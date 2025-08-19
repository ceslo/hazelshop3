<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
        private $session;
        public function __construct(
        private RequestStack $requestStack,     
        private ArticleRepository $articleRepository)
    {
        $this->session = $this->requestStack->getSession();
       
    }
    public function getPanier(){
        $panier = $this->session->get("panier", []);
        return $panier;
    }

    public function IndexPanier()
    {
        $panier = $this->session->get("panier", []);
        $panier_details = [];
        foreach ($panier as $id => $quantity) {
            $panier_details[] = [
                'article' => $this->articleRepository->find($id),
                'quantite' => $quantity,
            ];
        };
        return $panier_details;
    }

    public function totalPanier($panier_details, $coef)
    {
        // Je calcule le prix total du panier
        $total = 0;
        foreach ($panier_details as $item) {
            $totalItem = ($item['article']->getPrixAchat() * $coef) * $item['quantite'];
            $total += $totalItem;
           
        };
        return round($total,2);
    }

    public function addToCart($id)
    {
        $panier = $this->session->get("panier", []);

        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->session->set("panier", $panier);
    }

    public function removeAllFromCart($id)
    {
        $panier = $this->session->get("panier", []);
    
        unset($panier[$id]);

        $this->session->set("panier", $panier);
    }

    public function removeOneFromCart($id)
    {
        $panier = $this->session->get("panier", []);
        
        if ($panier[$id] > 1) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }
        $this->session->set("panier", $panier);
    }

    public function emptyCart()
    {
        $this->session->set("panier", []);

    }

    public function getFraisPort($total)
    {
        if ($total >= 100) {
            $frais_port = 0;
            return $frais_port;
        } else {
            $frais_port = 4.90;
            return $frais_port;
        }
    }

    public function getTotalCommande($total_articles, $coef, $remise, $frais_port)
    {
        if ($remise != null) {
            $total_commande = ($total_articles * $coef) - $remise + $frais_port;
            return $total_commande;
        } else {
            $total_commande = ($total_articles * $coef) + $frais_port;
            return $total_commande;
        }
    }
}
