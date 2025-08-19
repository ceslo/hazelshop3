<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\DetailsCommande;
use App\Entity\DetailsLivraison;
use App\Entity\Fournisseur;
use App\Entity\Livraison;
use App\Entity\TypeClient;
use App\Entity\TypeUtilisateur;
use App\Entity\Utilisateur;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    //1ère methode: Avec une base de données prééxistante:

        //on inclut les tableaux PHP de la base de données préétablie dans les exercices précedents
        include "hazelshop.php";

        //LES FOURNISSEURS
       
        //On remplit la base de donnée en utilisant le tableau PHP de la base pré-existante
        foreach ($fournisseur as $fourni)
        {
            $fDB=new Fournisseur;
            $fDB
            -> setId($fourni['id_fournisseur'])
            -> setNomFournisseur($fourni['nom_fournisseur'])
            -> setMailFournisseur($fourni['mail_fournisseur'])
            -> setTelFournisseur($fourni['tel_fournisseur']);
        // Pour empecher l'auto-incrementation de l'Id:
        $metadata= $manager->getClassMetadata(Fournisseur::class);
        $metadata-> setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        //On enregistre l'itération de la boucle
        $manager->persist($fDB);
        };
        //On envoie les modifications pour générer le code sql et mettre à jour la base
        $manager ->flush();
 
        
        //LES CATEGORIES

        // Pour appeler les repository des relations
        $categorieRepo= $manager-> getRepository(Categorie::class);

         //On rempli la base de donnée en utilisant le tableau PHP de la base pré-existante
         foreach ($categorie as $cat)
         {
            $catDB=new Categorie;
            $catDB-> setId($cat['id_categorie'])
                  -> setLibelleCategorie($cat['libelle_categorie'])
                  -> setImgCategorie($cat['img_categorie']);
            
                    
            // Pour empecher l'auto-incrementation de l'Id:
            $metadata= $manager->getClassMetadata(Categorie::class);
            $metadata-> setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE); 

             //on enregistre l'itération de la boucle
             $manager->persist($catDB);
             //on envoie les modifications pour générer le code sql et mettre à jour la base
             $manager ->flush();   
            
             //pour relier avec l'entité de la relation (categorie mère)
               if ($cat['categorie_mere']!= NULL){
                
                $categorieMere= $categorieRepo->find($cat['categorie_mere']);
                $catDB-> setCategorieMere($categorieMere);  
                  //on enregistre l'itération de la boucle
                $manager->persist($catDB);
                //on envoie les modifications pour générer le code sql et mettre à jour la base
                $manager ->flush();                       

               };
            
               
        };
        // LES ARTICLES (même schéma)

        // Pour appeler les repository des relations
        $categorieRepo= $manager-> getRepository(Categorie::class); 
        $fournisseurRepo= $manager-> getRepository(Fournisseur::class);        

        //On rempli la base de données en utilisant le tableau PHP de la base pré-existante
        foreach ($article as $art)
        {
            $artDB= new Article;
            $artDB-> setId($art['id_article'])
                  -> setLibelleArticle($art['libelle_article'])
                  -> setDescription($art['description'])
                  -> setImgArticle($art['img_article'])
                  -> setQteStock($art['qte_stock'])
                  -> setPrixAchat($art['prix_achat'])
                  -> setRefFournisseur($art['ref_fournisseur']);


            //pour relier avec l'entité  des relations
            $categorie= $categorieRepo->find($art['id_categorie']);
            $artDB-> setCategorie($categorie);

            $fournisseur=$fournisseurRepo->find($art['id_fournisseur']);
            $artDB->setFournisseur($fournisseur);

            // Pour empecher l'auto-incrémentation de l'Id:
            $metadata= $manager->getClassMetadata(Article::class);
            $metadata-> setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            //on enregistre l'itération de la boucle
            $manager->persist($artDB);
       
            //on envoie les modifications pour générer le code sql et mettre à jour la base
            $manager ->flush();
        };
      
    //2éme methode: en créant des valeurs

        //On ajoute un article
        $article1= new Article();
        $article1
            -> setLibelleArticle("Codenames")
            -> setDescription("Codenames est un jeu d’association d’idées pour 2 à 8 joueurs (voire plus !). Pour retrouver sous quel nom de code se cachent vos informateurs, écoutez bien les indices donnés par les deux maîtres-espions et prenez garde à ne pas contacter un informateur ennemi, ou pire… le redoutable assassin ! Si une équipe tombe par malchance sur ce vil personnage, la partie s'arrête et l'autre équipe remporte la mission.")
            -> setImgArticle("codenames.webp")
            -> setQteStock("5")
            -> setPrixAchat("14.50")
            -> setRefFournisseur("A50758");
          
        // pour relier à l'entité categorie
        $catArt1= $categorieRepo->find(2);
        $article1-> setCategorie($catArt1);

        //pour relier à l'entité fournisseur
        $fourniArt1= $fournisseurRepo->find(2);
        $article1-> setFournisseur($fourniArt1);
        
        $manager->persist($article1);
        $manager->flush();


       // Suite de la creation de la base avec les fixtures (uitilisation des 2 methodes)

        //Les types d'utilisateurs

        $typeUtilisateur1= new TypeUtilisateur();
        $typeUtilisateur1-> setLibelleUtilisateur("client");
        $manager->persist($typeUtilisateur1);
        
        $typeUtilisateur2= new TypeUtilisateur();
        $typeUtilisateur2-> setLibelleUtilisateur("commercial");
        $manager->persist($typeUtilisateur2);
        
        $typeUtilisateur3= new TypeUtilisateur();
        $typeUtilisateur3-> setLibelleUtilisateur("administrateur");
        $manager->persist($typeUtilisateur3);

        $manager->flush();

        // Les types de clients
        $typeClient1= new TypeClient();
        $typeClient1->setLibelle("particulier");
        $manager->persist($typeClient1);

        $typeClient2= new TypeClient();
        $typeClient2->setLibelle("professionnel");
        $manager->persist($typeClient2);

        $manager->flush();

        // Les utilisateurs

        $utilisateur1=new Utilisateur();
        $utilisateur1-> setNom("Scott");
        $utilisateur1->setPrenom("Michael");
        $utilisateur1->setPassword('$2y$13$dJKgt6PbEzC9fDbXjUsOD.SvyBkjW34DTaay0OhgPVWn/WMbglhFG');
        $utilisateur1->setEmail("m.scott@mail.com");
        $utilisateur1->setDateInscription(new DateTime('2020-09-06'));
        $utilisateur1->setTypeUtilisateur($typeUtilisateur1);
        $manager->persist($utilisateur1);
        $manager->flush();


        $utilisateur2=new Utilisateur();
        $utilisateur2->setNom("Palmer");
        $utilisateur2->setPrenom("Meredith");
        $utilisateur2->setPassword('$2y$13$Nx/KhOvL7cpjb3JvZy46T.GKE5vsSXFmO6UiWu1XxvSOg7935goh.');
        $utilisateur2->setEmail("m.palmer@mail.com");
        $utilisateur2->setDateInscription(new DateTime('2021-11-27'));
        $utilisateur2->setTypeUtilisateur($typeUtilisateur1);
        $manager->persist($utilisateur2);
        $manager->flush();


        $utilisateur3=new Utilisateur();
        $utilisateur3->setNom("Beesly");
        $utilisateur3->setPrenom("Pamela");
        $utilisateur3->setPassword('$2y$13$Nx/KhOvL7cpjb3JvZy46T.GKE5vsSXFmO6UiWu1XxvSOg7935goh.');
        $utilisateur3->setEmail("p.beesly@mail.com");
        $utilisateur3->setDateInscription(new DateTime('2021-11-27'));
        $utilisateur3->setTypeUtilisateur($typeUtilisateur1);
        $manager->persist($utilisateur3);
        $manager->flush();


        $utilisateur4=new Utilisateur();
        $utilisateur4->setNom("Convenant");
        $utilisateur4->setPassword('$2y$13$Nx/KhOvL7cpjb3JvZy46T.GKE5vsSXFmO6UiWu1XxvSOg7935goh.');
        $utilisateur4->setPrenom("Jean-Claude");
        $utilisateur4->setEmail("jc.convenant@mail.com");
        $utilisateur4->setDateInscription(new DateTime('2018-09-01'));
        $utilisateur4->setTypeUtilisateur($typeUtilisateur2);
        $manager->persist($utilisateur4);
        $manager->flush();

        $utilisateur5=new Utilisateur();
        $utilisateur5->setNom("Robin");
        $utilisateur5->setPrenom("Jean-Yves");
        $utilisateur5->setPassword('$2y$13$Nx/KhOvL7cpjb3JvZy46T.GKE5vsSXFmO6UiWu1XxvSOg7935goh.');
        $utilisateur5->setEmail("jy.robin@mail.com");
        $utilisateur5->setDateInscription(new DateTime('2019-10-01'));
        $utilisateur5->setTypeUtilisateur($typeUtilisateur2);
        $manager->persist($utilisateur5);
        $manager->flush();


        // Creation d'un administrateur

        $utilisateur6=new Utilisateur();
        $utilisateur6->setNom("admin");
        $utilisateur6->setPrenom("admin");
        $utilisateur6->setPassword('$2y$13$CxZfEbOAMBRfbZbjf4X7EeUzYUKQPYi6ljvw0ozR38EpX4lVhERSm');
        $utilisateur6->setEmail("admin@hazelshop.com");
        $utilisateur6->setDateInscription(new DateTime());
        $utilisateur6->setTypeUtilisateur($typeUtilisateur3);
        
        $utilisateur6->setRoles(['ROLE_ADMIN']);
        $manager->persist($utilisateur6);
        $manager->flush();


        //les Clients
        foreach($client as $cli){
            $cliDB= new Client();
            $cliDB->setNumClient($cli["num_client"]);
            $cliDB->setTelephone($cli["telephone"]);
            $cliDB->setCoefClient($cli["coef_client"]);
            $cliDB->setFormeJuridique($cli["forme_juridique"]);
            $cliDB->setRaisonSociale($cli["raison_sociale"]);
            $cliDB->setSiren($cli["siren"]);
            $cliDB->setNumTva($cli["num_tva"]);
            $cliDB->setReductionPro($cli["reduction_pro"]);       
            
            $typeClientRepo=$manager->getRepository(TypeClient::class);
            $typeclient= $typeClientRepo->find($cli["id_type_client"]);
            $cliDB->setTypeClient($typeclient);

            $manager->persist($cliDB);
            $manager->flush();
        };

        $clientRepository =$manager->getRepository(Client::class);
        $client1= $clientRepository->find(1);
        $client2= $clientRepository->find(2);
        $client3= $clientRepository->find(3);

        $utilisateur1->setClient($client1);
        $manager->persist($utilisateur1);
        
        $utilisateur2->setClient($client2);
        $manager->persist($utilisateur2);
        
        $utilisateur3->setClient($client3);   
        $manager->persist($utilisateur3);
        $manager->flush();

        //les adresses

        $adresse1=new Adresse;
        $adresse1->setLibelleAdresse("Maison");
        $adresse1->setNumero(7);
        $adresse1->setVoie("rue de la plage");
        $adresse1->setCp("02240");
        $adresse1->setVille("Scranton");
        $adresse1->setPays("France");
        $adresse1->setClient($client1);
        $manager->persist($adresse1);
       
        $adresse2=new Adresse;
        $adresse2->setLibelleAdresse("Bureau");
        $adresse2->setNumero(3);
        $adresse2->setVoie("rue de l'opéra");
        $adresse2->setCp("60120");
        $adresse2->setVille("Breteuil");
        $adresse2->setPays("France");
        $adresse2->setClient($client2);
        $manager->persist($adresse2);

        //Les commandes
        
        $commande1=new Commande;
        $commande1-> setDateCommande(new DateTime("2020-09-06"));
        $commande1->setCoefClient(1.35);
        $commande1->setTotal(25.43);
        $commande1->setNumFacture(1);
        $commande1->setFraisPort(4.90);
        $commande1->setModePaiement("CB");
        $commande1->setDelaisReglement(0);
        $commande1->setMontantRegle(30.33);
        $commande1->setStatut('livrée');        
        $commande1->setAdresseFacturation($adresse1);
        $commande1->setAdresseLivraison($adresse1);
        $commande1->setClient($client1);
        $manager->persist($commande1);

        $commande2=new Commande;
        $commande2-> setDateCommande(new DateTime("2021-12-20"));
        $commande2->setCoefClient(1.20);
        $commande2->setTotal(265.90);
        $commande2->setNumFacture(2);
        $commande2->setFraisPort(4.90);
        $commande2->setModePaiement("Virement");
        $commande2->setDelaisReglement(30);
        $commande2->setMontantRegle(270.80);
        $commande2->setStatut('livrée');        
        $commande2->setAdresseFacturation($adresse2);
        $commande2->setAdresseLivraison($adresse2);
        $commande2->setClient($client2);
        $manager->persist($commande2);
        $manager->flush();

        //Les details commandes

        $articleRepo=$manager->getRepository(Article::class);
        $art1=$articleRepo->find(1);
        $art6=$articleRepo->find(6);
        $art9=$articleRepo->find(9);     

        $detailsC1= new DetailsCommande();
        $detailsC1->setArticle($art6);
        $detailsC1->setCommande($commande1);
        $detailsC1->setQteArticle(1);
        $detailsC1->setPrixAchat(18.84);
        $manager->persist($detailsC1);
       
        $detailsC2= new DetailsCommande();
        $detailsC2->setArticle($art1);
        $detailsC2->setCommande($commande2);
        $detailsC2->setQteArticle(1);
        $detailsC2->setPrixAchat(79.90);
        $manager->persist($detailsC2);

        $detailsC3= new DetailsCommande();
        $detailsC3->setArticle($art9);
        $detailsC3->setCommande($commande2);
        $detailsC3->setQteArticle(4);
        $detailsC3->setPrixAchat(35.42);
        $manager->persist($detailsC3);

        $manager->flush();

        //Les livraisons
        $livraison1=new Livraison();
        $livraison1->setDateExpedition(new DateTime("2020-09-07"));
        $livraison1->setModeLivraison("domicile");
        $livraison1->setCommande($commande1);
        $manager->persist($livraison1);
        
        $livraison2=new Livraison();
        $livraison2->setDateExpedition(new DateTime("2021-12-21"));
        $livraison2->setModeLivraison("domicile");
        $livraison2->setCommande($commande2);
        $manager->persist($livraison2);   
        $manager->flush();

        //Les details livraison

        $detailL1=new DetailsLivraison();
        $detailL1->setArticle($art6);
        $detailL1->setLivraison($livraison1);
        $detailL1->setQteLivree(1);
        $manager->persist($detailL1);
       
        $detailL2=new DetailsLivraison();
        $detailL2->setArticle($art1);
        $detailL2->setLivraison($livraison2);
        $detailL2->setQteLivree(1);
        $manager->persist($detailL2);

        $detailL3=new DetailsLivraison();
        $detailL3->setArticle($art9);
        $detailL3->setLivraison($livraison2);
        $detailL3->setQteLivree(4);
        $manager->persist($detailL3);

        $manager->flush();       
     
    }
}


//Commande pour executer la fixture: php bin/console doctrine:fixtures:load 
