<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])

            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])

            ->add('dateNaissance', null, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ]
                ],DateType::class)
                
            ->add('dateEmbauche', null, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ]
                ],DateType::class)

            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])

            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'raisonSociale',  //champs qui m'interesse dans l'affichage 
                'attr'=>  [
                    'class' => 'form-control',
                ]
            ])

            ->add('valider',SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class ,
        ]);
    }
}
