<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjoutPanierTest extends WebTestCase
{
    public function testAjoutArkeis(): void
    {

        $client = static::createClient();
        // On arrive sur la page d'acceuil 
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        //On clique sur le lien d'une catégorie

        $link = $crawler->selectLink("Jeux Experts")->link();
        
        //On selectionne le lien "jeux experts"
        $crawler = $client->click($link);
        $this->assertResponseIsSuccessful("le lien 'jeux experts' ne mène pas à une page accessible");
        $this->assertSelectorExists("a.card","la catégorie est vide");

        //On clique sur le lien de la sous-catégorie jeux coopératifs
        $link = $crawler->selectLink("Jeux coopératifs")->link();
        $crawler = $client->click($link);

        $this->assertResponseIsSuccessful("le lien 'jeux coopératifs' ne mène pas à une page accessible");
        $this->assertSelectorExists("a.card", "la sous-catégorie est vide");
         
        //On clique sur le lien de l'article Arkeis
         
        $link = $crawler->selectLink("Arkeis")->link();
        $crawler = $client->click($link);

        $this->assertResponseIsSuccessful("le lien 'Arkeis' ne mène pas à une page accessible");
        // $this->assertSelectorExists("a.card", "les details de l'article ne s'affiche pas");

        //On ajoute l'article au panier

        $link = $crawler->selectLink("Ajouter au panier")->link();
        $crawler = $client->click($link);
        
        $this->assertResponseRedirects('/panier');

        //Pour suivre la redirection
        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains("p.libelle","Arkeis");
        $this->assertSelectorTextContains("p.quantite", 1);
        $this->assertSelectorTextContains("p.prix","101.14");
        












    }
}
