<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CatalogueController extends AbstractController

{ 
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(ArticleRepository $articleRepository, CategorieRepository $categorieRepository): Response
    {
        $articles=$articleRepository->findAll();
        $categories=$categorieRepository->findBy(['categorie_mere'=>null]);
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories'=>$categories,
            'articles'=>$articles,
        ]);
    }

    #[Route('/catalogue/categorie/{id}', name: 'app_details_categories')]
    public function affichageSousCategorie($id, CategorieRepository $categorieRepository, ArticleRepository $articleRepository):Response
    {
        $categories= $categorieRepository->findBy(['categorie_mere'=>$id]);
        $articles = [];
        if ($categories == NULL){
        $articles= $articleRepository->findBy(['categorie'=>$id]);
        
        };        
        return $this->render('catalogue/detailsCategorie.html.twig',[
            'controller_name'=> 'CatalogueController',
            'categories'=> $categories,
            'articles'=> $articles,
        ]);
    }

    #[Route('/catalogue/article/{art_id}', name: 'app_details_article')]
    public function affichageDetailsArticles(Request $request , ArticleRepository $articleRepository):Response
    {
        $id=$request->attributes->get('art_id');

        $article= $articleRepository->find($id);

        return $this->render('catalogue/detailsArticle.html.twig',[
            'controller_name'=> 'CatalogueController',
            'article'=> $article,
        ]);
    }


}
