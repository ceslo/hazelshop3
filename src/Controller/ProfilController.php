<?php

namespace App\Controller;

use App\Form\ClientType;
use App\Form\UtilisateurFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $form=$this->createForm(ClientType::class);
        return $this->render('profil/index.html.twig', [
           'form'=>$form
        ]);
    }
}
