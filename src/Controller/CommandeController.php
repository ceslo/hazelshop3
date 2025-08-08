<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Form\AdresseCommandeType;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\UtilisateurRepository;
use App\Service\PanierService;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CommandeController extends AbstractController
{  
    #[Route('/commande', name: 'app_commande')]
    public function index(Request $request, UtilisateurRepository $utilisateurRepo, ClientRepository $clientRepo, AdresseRepository $adresseRepository, EntityManagerInterface $entityManager,PanierService $panierService): Response
    {       
        // Recupération des données de l'utilisateur
      
        $utilisateur= $this->getUser();
        

        if (!$utilisateur) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour continuer');
            // return $this->redirectToRoute('app_login');
        } 
        
        // On récupère le contenu du panier
           
        $panier_details=$panierService->IndexPanier();
        
        // on recupère les données du client associé l'utilisateur
        $email = $utilisateur->getUserIdentifier();
        $u = $utilisateurRepo->findOneBy(["email" => $email]);
        $clientID= $u->getClient();
        $client=$clientRepo->findOneBy(["id"=>$clientID]);
                  
        
        // on récupère les adresses connues
        $adresses = $adresseRepository->findBy(['client' => $client]);
        // dd($adresses);

        $options=['utilisateur'=>$utilisateur];
        $form1 = $this->createForm(AdresseCommandeType::class,null, $options);
        $form1->handleRequest($request);
        
        $form2=$this->createForm(AdresseType::class);
        $form2->handleRequest($request);

        //Calcul du montant total de la commande
        $remise=null;      
        $coef=$client->getCoefClient();
        $total_articles=$panierService->totalPanier($panier_details,$coef);
        $frais_port=$panierService->getFraisPort($total_articles);       
        $total_commande=$panierService->getTotalCommande($total_articles,$coef,$remise,$frais_port);
        //dd($coef);
    

        // Choix de l'adresse
        $adresse= Adresse::class;

        if ($form1->isSubmitted() && $form1->isValid()) {
        // Récupère l'adresse existante
            $adresse = $form1->getData();
        }            
        // OU
        if ($form2->isSubmitted() && $form2->isValid()) {
        // Créé l'adresse       
            $adresse = $form2->getData()
                ->setClient($client);
            $entityManager->persist($adresse);
            $entityManager->flush();
            
        };

        //choix du mode de paiement

     
        $form3 = $this->createFormBuilder()
        ->add('mode_paiement', ChoiceType::class,[
            'choices'=>[
                'Carte bancaire'=>'CB',
                'Virement Bancaire'=>'virement'
            ],
            'multiple'=>false,
            'expanded'=>true
        ])
        ->add('save', SubmitType::class, ['label' => 'choisir ce mode de paiement'])
        ->getForm();

        $form3->handleRequest($request);
        $mode= $form3->getData('mode_paiement');

    
    
        
        // $commande=new Commande();
        // $commande
        //     ->setClient($client)
        //     ->setAdresseLivraison($adresse)
        //     ->setAdresseFacturation($adresse)
        //     ->setDateCommande(new DateTime('now'))
        //     ->setFraisPort("4.90")
        //     ->setModePaiement("CB")
        //     ->setDelaisReglement("0")
        //     ->setStatut("Enregistrée");
            

          

        return $this->render('commande/index.html.twig', [
            'utilisateur'=>$utilisateur, 
            'panier'=>$panier_details,
            'client'=>$client,
            'adresses'=>$adresses,
            'form1' => $form1,
            'form2' => $form2,
            'form3'=>$form3,
            'total_articles'=>$total_articles,
            'frais_port'=>$frais_port,
            'total_commande'=>$total_commande,
            'remise'=>$remise,
        ]);
    }


    // #[Route('/commande/livraison', name: 'app_commande_livraison')]
    // public function livraison(){
 
    // }

}

