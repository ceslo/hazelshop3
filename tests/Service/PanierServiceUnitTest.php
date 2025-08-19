<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PanierService;
use App\Repository\ArticleRepository;

class PanierServiceUnitTest extends TestCase
{
     /** @var SessionInterface&MockObject */
    private $session;

    /** @var ArticleRepository&MockObject */
    private $artRepo;


    private PanierService $panierService;

    protected function setUp(): void
    {
        // Mock de la session
        $this->session = $this->createMock(SessionInterface::class);

        // Mock de RequestStack
        $request = $this->createMock(Request::class);
        $request->method('getSession')->willReturn($this->session);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->method('getSession')->willReturn($this->session);
        $requestStack->method('getCurrentRequest')->willReturn($request);

        // Mock du repository
        $this->artRepo = $this->createMock(ArticleRepository::class);
        
        /** @var RequestStack $requestStack */
        // Instanciation du service avec les mocks
        $this->panierService = new PanierService($requestStack, $this->artRepo);
    }

    public function testAddToCartUT(): void
{
    // On s’attend à ce que la session récupère le panier vide
    $this->session->expects($this->once())
        ->method('get')
        ->with('panier', [])
        ->willReturn([]);

    // On s’attend à ce que la session soit mise à jour
    $this->session->expects($this->once())
        ->method('set')
        ->with('panier', [43 => 1]);

    $this->panierService->addToCart(43);
}
}   