<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\SecurityBundle\Security;


class ClientService { 
    private $utilisateur;     
    
    public function __construct(private Security $security, private UtilisateurRepository $utilisateurRepo, private ClientRepository $clientRepo){

    $this->utilisateur=$this->security->getUser();

    }
    
    public function findClient() {
         
        $utilisateur=$this->utilisateur;
    
        $email = $utilisateur->getUserIdentifier();
        $u =$this->utilisateurRepo->findOneBy(["email" => $email]);
        $clientID= $u->getClient();
        $client=$this->clientRepo->findOneBy(["id"=>$clientID]);
        return $client;

        }
    

    public function findCoef(){ 
        
        $utilisateur=$this->utilisateur;
        
        if($utilisateur != null){
        $email = $utilisateur->getUserIdentifier();
        $u =$this->utilisateurRepo->findOneBy(["email" => $email]);
        $clientID= $u->getClient();
        $client=$this->clientRepo->findOneBy(["id"=>$clientID]);
        $coef=$client->getCoefClient();
        return $coef;
        }
        else{
            $coef=1.35;
            return $coef;
        };
    }

}









   