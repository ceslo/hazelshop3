<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

  public function configureFilters(Filters $filters): Filters
  {
    return parent::configureFilters($filters)
    ->add(EntityFilter::new('Fournisseur'));
  }
  
  


    public function configureFields(string $pageName): iterable
    {
        return [
            
            IdField::new('id')
            ->onlyOnIndex(),
            TextField::new('libelleArticle', "Libelle de l'article"),
            TextEditorField::new('description'),
            ImageField::new('imgArticle', 'Image')
            ->setBasePath('public/img/')
            ->setUploadDir('public/img'),
            TextField::new('refFournisseur', 'Référence'),
            IntegerField::new ('qteStock', 'Quantité en Stock'),
            MoneyField::new('prixAchat', "Prix d'achat")
                ->setCurrency('EUR')
                ->setCustomOption('storedAsCents', false),
            AssociationField::new('categorie'),
            AssociationField::new('fournisseur'),
        ];
    }
    
}
