<?php

namespace App\Tests\Controller;

use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierControllerTest extends WebTestCase
{
    public function testAffichage(): void
    {
        $client=static::createClient();

        $client->request('GET', '/panier');

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('h1','Votre panier est vide!');
    }

    public function testAddToCart(): void
    {
        //Creation du client
        $client=static::createClient();  
        
        //Pour tester la route qui ajoute un article
        $client->request('GET', '/panier_add/1');
        $this->assertResponseRedirects('/panier');

        //Pour suivre la redirection
        $client->followRedirect();

        // Pour vérifier que la page panier s'affiche
        $this->assertResponseIsSuccessful();

        // Vérifier que le produit ajouté apparaît (en fonction de ton HTML)
        // $this->assertSelectorTextContains('.product-name', 'Nom du produit 1');
        $this->assertSelectorNotExists('h1','Votre panier est vide!');
        
    }  
    
        // $session= $client->getContainer()->get('session');
        // $session->set('panier',[]);

        // $client = static::createClient();
        
        // $panierService = static::getContainer()->get(PanierService::class);
       
        // //Récupération de la session dans un conteneur
        // $session = static::getContainer()->get(SessionInterface::class);
        
        // // Démarrage manuel de la session si nécessaire
        // if (!$session->isStarted()) {
        //     $session->start();
        // }

        // $crawler = $client->request('GET', '/panier');

        // $this->assertResponseIsSuccessful();

        // $panierService->addToCart(1);
    
        // $panier=$this->$session->get('panier');

        // $this->assertSame($panier,[1,1]);
    
}
