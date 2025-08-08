<?php

namespace App\Controller;

use App\Form\AdresseCommandeType;
use App\Form\AdresseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class AdresseController extends AbstractController
{
    #[Route('/adresse', name: 'app_adresse')]
    public function index(Request $request, SessionInterface $ŝession): Response
    {
        $utilisateur= $this->getUser();
        // dd($utilisateur);
        $form1=$this->createForm(AdresseType::class);
     
        // $form2 = $this->createForm(AdresseCommandeType::class,['utilisateur'=>$utilisateur]);
        
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
            'form1'=>$form1,
        //     'form2'=>$form2,
        ]);
    }
}
