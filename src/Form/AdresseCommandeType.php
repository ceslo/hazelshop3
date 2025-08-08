<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Utilisateur;
use App\Repository\AdresseRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $utilisateur= $options['utilisateur'];
       
        $builder
            ->add('Adresse', EntityType::class, [
               'label' => 'Vos adresses',
                'class' => Adresse::class,
                'choice_label' => 'libelleAdresse',
                'placeholder' => 'Choissisez une de vos adresses connues',
                'query_builder' => function (AdresseRepository $adresseRepository) use($utilisateur) {
                   
                    return $adresseRepository->createQueryBuilder('a')
                    ->join('a.client', 'c') // Relation entre Adresse et Client
                    ->where('c.id = :clientId') // Relation entre Client et Utilisateur
                    ->setParameter('clientId', $utilisateur->getClient()->getId());
                                    
                },
                'multiple' => false,
                'expanded' => false,
            ])
            
            // ->add('nouvelleAdresse', AdresseType::class, [ // Un autre formulaire pour créer une adresse
            //     'required' => false,
            //     'label' => 'Utiliser une nouvelle adresse'
            // ])
            ->add('save', SubmitType::class, ['label' => "Choisir cette adresse"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'utilisateur' => null
        ]);
    }
}
