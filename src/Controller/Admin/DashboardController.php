<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Fournisseur;
use App\Entity\Utilisateur;
use App\Repository\FournisseurRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $qteByFournisseur= $this->fournisseurRepository->qteArtSoldByFourni();
       ;

        
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }
    private FournisseurRepository $fournisseurRepository;
    public function __construct(FournisseurRepository $fournisseurRepository)
    {
        $this->fournisseurRepository =$fournisseurRepository;
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hazelshop Gestion')
            ->renderContentMaximized(true)
            ->setLocales(['fr']);
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list'(=ref de l'icone fontawesome), EntityClass::class);
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::subMenu('Catalogue', 'fa fa-folder')->setSubItems([
                    MenuItem::linkToCrud('Articles', 'fa fa-tags', Article::class),
                    MenuItem::linkToCrud('Categories', 'fa fa-th-list', Categorie::class),]);
        yield MenuItem::linkToCrud('Fournisseurs', 'fa fa-truck', Fournisseur::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user-circle', Utilisateur::class);       
        yield MenuItem::linkToCrud('Clients', 'fa fa-folder', Client::class);
        yield MenuItem::linkToUrl('Accueil du site', 'fa fa-home', $this->generateUrl('app_accueil'));
        
    }
    
    public function configureAssets(): Assets
    {    
        return parent::configureAssets()
        ->addCssFile('/css/admin.css');
    }
}
