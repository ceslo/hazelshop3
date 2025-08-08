<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\TypeClient;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone')
            ->add('type_client', EntityType::class, [
                'class' => TypeClient::class,
'choice_label' => 'libelle',
            ])
            ->add('forme_juridique')
            ->add('raison_sociale')
            ->add('siren')
            ->add('num_tva')           
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
'choice_label' => 'id',
            ])
            ->add('type_client', EntityType::class, [
                'class' => TypeClient::class,
'choice_label' => 'libelle',
            ])
            ->add('commercial', EntityType::class, [
                'class' => Utilisateur::class,
'choice_label' => 'nom',
            ])  
            ->add('adresses', CollectionType::class, [
                'entry_type'=>AdresseType::class,
                'allow_add'=>true,  
                'attr'=>['data-controller'=>'form_collection']                       
            ])     
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
