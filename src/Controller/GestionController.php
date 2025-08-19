<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GestionController extends AbstractController
{
    #[Route('/gestion', name: 'app_gestion')]
    public function index(EntityManager $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        //pour ajouter un article
        $formArticle= $this->createForm(ArticleFormType::class); 
        $formArticle->handleRequest($request);

        if ($formArticle->isSubmitted() && $formArticle->isValid())
        {
            $newArticle= new Article();
            $data= $formArticle->getData();
            $newArticle=$data;
            $entityManager->persist($newArticle);
            $entityManager->flush();
            return $this-> redirectToRoute('/gestion');
        }
        
        return $this->render('gestion/index.html.twig', [
            'controller_name' => 'GestionController',
            'formArticle'=> $formArticle
        ]);
    }    
}
