<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class AccueilController extends AbstractController
{
    private $categorieRepository; 

 public function __construct(CategorieRepository $categorieRepository)
 {

    $this-> categorieRepository =$categorieRepository;
    
 }
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        // $categories= $this->categorieRepository-> findAll();
        // $categories= $this->categorieRepository->getCategorieMereOnly();
        $categories= $this->categorieRepository->findBy(["categorie_mere"=>null]);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'categories'=> $categories,
        ]);
    }
}
