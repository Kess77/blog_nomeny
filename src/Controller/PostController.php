<?php

namespace App\Controller;

use App\Repository\PostRepository;
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
    /**
     * Permet de créer des articles ou d'ajouter
     * 
     * @Route("posts/new",name="post_create")
     *
     * @return Response
     */
    public function create(){

        return $this->render('post/create.html.twig',[

        ]);

    }
}
