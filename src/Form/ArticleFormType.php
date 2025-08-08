<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use Doctrine\DBAL\Types\DecimalType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle_article', TextType::class ,[
            'label' => "Libelle de l'article"
            ])
            ->add('description', TextareaType::class ,[
                'label' => "Description"
                ])
            ->add('img_article', TextType::class ,[
                'label' => "Image"
                ])
            ->add('qte_stock',NumberType::class,[
                'label' => "Quantité en stock",
                'required'=> false
                ])
            ->add('prix_achat', NumberType::class, [
                'label' => "Prix d'achat en euros"
                ])
            ->add('ref_fournisseur',TextType::class,[
                'label' => "Référence"
                ]) 
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
            'choice_label' => 'libelle_categorie',
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nom_fournisseur',
            ])
            ->add ('save', SubmitType::class, [
                'label'=> "Ajouter l'article au catalogue"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
