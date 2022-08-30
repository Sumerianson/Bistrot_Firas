<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Votre nom :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Votre numéro de téléphone :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('adresse', TextareaType::class, [
                'label' => 'Votre adresse :',                
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('complement', TextareaType::class, [
                'label' => 'Votre complément d\'adresse :',                
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('codePostale', IntegerType::class, [
                'label' => 'Votre code postal :',                
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Votre ville :',                
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Votre genre :',                
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                    'Autre' => 'autre',
                ],
                'mapped' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-select'
                ],
            ])
            ->add('naissance', DateType::class,[
                'label' => 'Votre date naissance :',                
                'widget' => 'choice',
                'years' => range(date('Y')-100,date('Y')-20),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('avatar', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize'=>'16384k',
                        'maxSizeMessage'=>'Taille de fichier trop grande',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/png',
                            'image/svg',
                            'image/jpg',
                            'image/webp',
                        ],
                        'mimeTypesMessage'=>'Extension de fichier invalide',
                    ])
                    ],
                'attr'=>[
                    'class'=>'form-control',
                ],
                'data_class'=>null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
