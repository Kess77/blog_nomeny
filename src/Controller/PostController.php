<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Image;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * Permet d'afficher la page d'accueil des articles.
     * 
     * @Route("/posts", name="post_index")
     */
    public function index(PostRepository $repo)
    {
        $posts = $repo->findAll();

        return $this->render('post/index.html.twig', [

            'posts' => $posts
        ]);
    }
    
    /**
     * Permet de créer des articles ou d'ajouter, lier avec des formulaires
     * 
     * @Route("posts/new",name="post_create")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $post = new Post;
        $image = new Image;
        //$image->setUrl('http://placehold.it')
        //      ->setCaption('titre 1');

        //$post->addImage($image);

        $form = $this->createForm(PostType::class,$post);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            foreach($post->getImages() as $image){
                $image->setPost($post);
                $manager->persist($image);
            }



            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong> {$post->getTitle()} </strong> a été bien enregistrée"
            );

            return $this->redirectToRoute("post_show",[
                'slug'=>$post->getSlug()
            ]);

        }

        return $this->render('post/create.html.twig',[
            'form'=>$form->createView()

        ]);

    }
    /**
     * Permet d'afficher le formulaire d'edition pour pouvoir modifier 
     *
     * @Route("posts/{slug}/edit",name="post_edit")
     * @Security(is_granted('ROLE_USER')and user===post.getAuthor()",message="Interdiction de modifier cette article")
     * 
     * @return Response
     */
    public function edit(Post $post, Request $request, EntityManagerInterface $manager){
        
        //$post = $repo->findOneBySlug($slug);
        $form = $this->createForm(PostType::class,$post);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            foreach($post->getImages() as $image){
                $image->setPost($post);
                $manager->persist($image);
            }



            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong> {$post->getTitle()} </strong> a été bien modifié"
            );

            return $this->redirectToRoute("post_show",[
                'slug'=>$post->getSlug(),
                
            ]);

        }

        return $this->render('post/edit.html.twig',[
            'form'=>$form->createView(),
            'post'=>$post
            
        ]);
    }
     /**
     * Permet d'afficher une seule articles 
     * 
     * @Route("posts/{slug}",name="post_show")
     *
     * 
     */
    public function show($slug, PostRepository $repo)
    {
        $post = $repo->findOneBySlug($slug);

        return $this->render('post/show.html.twig',[
            'post'=>$post
        ]);

    }
}
