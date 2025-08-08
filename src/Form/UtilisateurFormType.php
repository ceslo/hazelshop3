<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\TypeUtilisateur;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles')
            ->add('password', PasswordType::class,['label'=>'Mot de passe'])
            ->add('prenom')
            ->add('nom')
            // ->add('date_inscritption', null, [
            //     'widget' => 'single_text'
            // ])
            ->add('pseudo', TextType::class, [
                'required' => 'false'
            ])
            // ->add('client', EntityType::class, [
            //     'class' => Client::class,
            //     'choice_label' => 'id',
            //     'required' => 'flase'
            // ])
            // ->add('typeUtilisateur', EntityType::class, [
            //     'class' => TypeUtilisateur::class,
            //     'choice_label' => 'libelleTypeUtilisateur',
            // ])

            ->add('adresses', CollectionType::class, [
                'entry_type'=>AdresseType::class,
                'allow_add'=>true,

                             
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Creer le profil'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
