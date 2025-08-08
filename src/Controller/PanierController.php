<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\UtilisateurRepository;
use App\Service\ClientService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    public function __construct( private PanierService $panierService, private ClientService $clientService) { 
    }    

    #[Route('/panier', name: 'app_panier')]
    public function index(UtilisateurRepository $utilisateurRepo, ClientRepository $clientRepo): Response
    {         
        // if($utilisateur){
        // $email = $utilisateur->getUserIdentifier();
        // $u = $utilisateurRepo->findOneBy(["email" => $email]);
        // $clientID= $u->getClient();
        // $client=$clientRepo->findOneBy(["id"=>$clientID]);
        // $coef=$client->getCoefClient();
       
        $coef=$this->clientService->findCoef();

        $panier_details=$this->panierService->IndexPanier();
        $total=$this->panierService->totalPanier($panier_details, $coef);
           
    //    dd($panier);
        return $this->render('panier/index.html.twig', [
            'panier' => $panier_details,
            'total' =>$total,
            'coefCli'=>$coef,
        ]);
    }

    #[Route('/panier_add/{id}', name: 'app_panier_add')]
    public function addToCart($id): Response
    {
       $this->panierService->addToCart($id);

        return $this->redirect("/panier");
        // return $this->redirectToRoute("app_panier");
    }

    #[Route('/panier_remove/{id}', name: 'app_panier_remove_one')]
    public function removeOneFromCart($id): Response
    {   $this->panierService->removeOneFromCart($id);

        // return $this->redirect("/panier");
        return $this->redirectToRoute("app_panier");
    }

    #[Route('/panier_remove_all/{id}', name: 'app_panier_remove_all')]
    public function removeAllFromCart($id): Response
    {
        $this->panierService->removeAllFromCart($id);

        return $this->redirect("/panier");
        // return $this->redirectToRoute("app_panier");
    }
}
