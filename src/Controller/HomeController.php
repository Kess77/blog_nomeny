<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(PostRepository $postRepo)
    {

        return $this->render('home/index.html.twig', [
            'posts' => $postRepo->findLastPost(4)
            
        ]);
    }
    /**
     * @Route("/show",name="homepage_show")
     */

     public function show (){

        return $this->render('home/show.html.twig');
     }
}
