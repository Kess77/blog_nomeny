<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;

use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class PostType extends ApplicationType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfiguration("Titre","Tapez un titre pour votre annonce ")
            )
            ->add(
                'introduction',
                TextType::class,
                $this->getConfiguration("Introduction","Donnez une description globale")
            )
            ->add(
                'article',
                TextareaType::class,
                $this->getConfiguration("Article","Mettez ici votre article...")
            )
            ->add(
                'categories',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'by_reference' => false,
                    'multiple' => true,
                    'attr' => [
                        'class' => 'js-select2'
                    ]
                ]
            )
             ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $post = $event->getData();
                $form = $event->getForm();

                $form->add(
                    'coverImage',
                    ImageType::class,
                    [
                        'required' => !$post->getId()
                    ]
                );

            })
            //gerer les sous formulaire pour afficher les images 
            ->add(
                'imageFirst',
                ImageType::class,
                [
                    'required' => false
                ]
            )
             ->add(
                'imageSecond',
                ImageType::class,
                 [
                    'required' => false
                ]
            )
             ->add(
                'imageLast',
                ImageType::class,
                 [
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
