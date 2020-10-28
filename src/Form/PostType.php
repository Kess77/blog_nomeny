<?php

namespace App\Form;

use App\Entity\Post;

use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class PostType extends AbstractType
{
    private function getConfiguration($label,$placeholder){
        return [
            'label'=>$label,
            'attr'=>[
                'placeholder'=>$placeholder
            ]
        ];

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfiguration("Titre","Tapez un titre pour votre annonce ")
            )
            ->add(
                'createdAt',
                 DateType::class,
                 $this->getConfiguration("Date de création","jj/mm/aaaa")
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
                'coverImage',
                UrlType::class,
                $this->getConfiguration("Url de l'image","Mettez une image sur votre article ")
            )
            //gerer les sous formulaire pour afficher les images 
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type'=>ImageType::class,
                    'allow_add'  => true
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
