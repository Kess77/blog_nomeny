<?php

namespace App\Form;

use App\Entity\Contact;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',
                TextType::class,
                $this->getConfiguration('Nom',""))
            ->add('lastName',
                TextType::class,
                $this->getConfiguration('Prénom',""))
            ->add('email',
            EmailType::class,
            $this->getConfiguration('Email',""))
            ->add('comments',
            TextType::class,
            $this->getConfiguration('Votre message',""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
