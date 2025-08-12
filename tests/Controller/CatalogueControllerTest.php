<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogueControllerTest extends WebTestCase
{
    public function testAffichageCatalogueComplet(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/catalogue');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Notre catalogue');
        $this->assertSelectorTextContains('h2', 'Tous nos jeux');
        $this->assertSelectorExists('.filtre_cat', "Les catégories devraient être affichées");
        $this->assertSelectorExists('.art', "Aucun article n'est affiché");        
    }

    public function testLiensCatalogueNavBar():void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/catalogue');

        $this->assertSelectorTextContains('a.nav-link.dropdown-toggle', 'CATALOGUE', "Le menu dropdown Catalogue n'est pas présent dans la barre de navigation. ");
       
        $links = [            
            "Tous nos jeux",
            "Jeux Experts",
            "Jeux d'Ambiance",
            'Escape Games',
        ];

        foreach ($links as $linkText) {
            $link = $crawler->selectLink($linkText)->link();
            $client->click($link);

            $this->assertResponseIsSuccessful(
                "Le lien '{$linkText}' ne mène pas à une page accessible"
            );
        }
    }
}
