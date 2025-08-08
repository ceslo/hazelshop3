<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('from', TextType::class,['label'=>'Votre Email*'])
            ->add('sujet', ChoiceType::class,['label'=>'Quel est le sujet de votre message?*',
            'choices'=>['Une commande'=>'commande', 'Une livraison'=>'livraison', 'Un article'=>'article','Une autre demande'=>'autre']])
            ->add('message', TextareaType::class,['label'=>'Votre message*'])
            ->add('envoyer', SubmitType::class, ['label'=>'Envoyer le message', 'attr'=>['class'=>'btn btn-outline-dark']])
        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
