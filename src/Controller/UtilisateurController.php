<?php

namespace App\Controller;

use App\Form\UtilisateurFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {

        $form=$this->createForm(UtilisateurFormType::class);


        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
            'form'=>$form
        ]);
    }
}
