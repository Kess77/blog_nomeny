<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Image;
use App\Form\PostType;
use App\Entity\Category;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
        $posts = $repo->findBy([],['createdAt'=>'DESC'],4);

        return $this->render('post/index.html.twig', [

            'posts' => $posts
        ]);
    }
    /**
     * Permet de filtrer par le champ recherche   
     * 
     * @Route("posts/search/",name="post_search")
     *
     * 
     */
    public function search(PostRepository $repo, Request $request)
    {
            $searchTerm = $request->get('q');
        return $this->render('post/index.html.twig',[
            'posts'=>$repo->search($searchTerm)
        ]);

    }
    
     /**
     * Permet d'afficher une seule articles 
     * 
     * @Route("posts/{slug}",name="post_show")
     *
     * 
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig',[
            'post'=>$post
        ]);

    }
     /**
     * Permet d'afficher les articles par categories  
     * 
     * @Route("posts/category/{id}",name="post_show_categorie")
     *
     * 
     */
    public function showCategorie(Category $category,PostRepository $repo )
    {

        return $this->render('post/index.html.twig',[
            'posts'=>$repo->getPostByCategory($category->getId(),5)
        ]);

    }
    
    
    
}
