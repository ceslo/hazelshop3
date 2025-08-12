<?php

namespace App\Tests\Service;

use App\Repository\ArticleRepository;
use App\Service\PanierService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class PanierServiceTest extends KernelTestCase
{
    private Session $session;
    private ArticleRepository|MockObject $artRepo;
    private PanierService $panierService;

    protected function setUp(): void
    {
        $kernel= self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());

        $container = static::getContainer();

        // On crée un stockage de session isolé en mémoire
        $this->session = new Session(new MockArraySessionStorage());
        $this->session->start();

        // On crée une Request factice et on lui attache cette session
        $request = new Request();
        $request->setSession($this->session);

        // On crée un RequestStack isolé avec cette Request
        $requestStack = new RequestStack();
        $requestStack->push($request);

        // On peut soit utiliser un vrai repo depuis le container,
        // Récupération du vrai repository depuis le container
        $this->artRepo = $container->get(ArticleRepository::class);


        // // soit un mock pour isoler la base de données
        // $this->artRepo = $this->createMock(ArticleRepository::class);
        // Par exemple : on définit que find($id) retournera un faux article
        // $this->artRepo->method('find')->willReturn(new Article(...));

        // On instancie le service avec notre RequestStack mocké
        $this->panierService = new PanierService($requestStack, $this->artRepo);
        
        // On nettoie la session avant chaque test
        $this->session->clear();
    }
  
    public function testAddOneToCart(): void
    {
        //On récupère le panier dans la session du conteneur test
        $panier= $this->session->get("panier",[]);

        //On vérifie que le panier ne contient pas déjà l'article
        $this->assertArrayNotHasKey(2, $panier, "le panier contient déja l'article avant l'ajout");
        //On applique la methode à tester
        $this->panierService->addToCart(2);
        //On récupère le panier mis à jour 
        $panier = $this->session->get("panier",[]);
        //On vérifie que l'article a bien été ajouté et que la quantité est correcte (1)
        $this->assertArrayHasKey(2, $panier, "L'article n'a pas été ajouté au panier");
        $this->assertSame(1, $panier[2], "La quantité d'article ajoutée n'est pas correcte");
    }

    public function testAddManyToCart(): void
    {
        //On récupère le panier dans la session du conteneur test
        $panier= $this->session->get("panier",[]);

        //On vérifie que le panier ne contient pas déjà l'article
        $this->assertArrayNotHasKey(2, $panier, "le panier contient déja l'article avant l'ajout");

        $this->panierService->addToCart(2);
        $this->panierService->addToCart(2);
     
        $panier = $this->session->get("panier", []);
        $this->assertArrayHasKey(2, $panier, "L'article n'a pas été ajouté au panier");
        $this->assertSame(2, $panier[2], "La quantité d'article ajoutée n'est pas correcte");
    }

    public function testIndexPanier():void
    {
        $panier_details= $this->panierService->IndexPanier();
        $this->assertsame([], $panier_details);
        
        $this->session->set("panier",[1=>1 , 2=>3]);

        $panier_details= $this->panierService->IndexPanier();
        $this->assertSame($panier_details = [
            ['article'  => $this->artRepo->find(1),'quantite' => 2,],
            ['article'  => $this->artRepo->find(2),'quantite' => 3, ]
        ], $panier_details);
    }
        // $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
}

