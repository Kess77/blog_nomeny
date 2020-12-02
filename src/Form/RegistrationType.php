<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                $this->getConfiguration('Nom')
                )
            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration('Prénom')
                )
            ->add(
                'email',
                EmailType::class,
                $this->getConfiguration('Email')
                )
            
            ->add(
                'password',
                PasswordType::class,
                $this->getConfiguration('Password')
                )
            ->add('confirmPassword',
                PasswordType::class,
                $this->getConfiguration('Veuillez confirmer votre Password')
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
