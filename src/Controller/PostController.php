<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
     * Permet de créer des articles ou d'ajouter
     * 
     * @Route("posts/new",name="post_create")
     *
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $post = new Post;

        $form = $this->createForm(PostType::class,$post);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){

            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong> {$post->getTitle()} </trong> a été bien enregistrée"
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
     * Permet d'afficher une seule articles 
     * 
     * @Route("posts/{slug}",name="post_show")
     *
     * 
     */
    public function show($slug,PostRepository $repo)
    {
        $post = $repo->findOneBySlug($slug);

        return $this->render('post/show.html.twig',[
            'post'=>$post
        ]);

    }
}
