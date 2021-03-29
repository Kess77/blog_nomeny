<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * Permet d'afficher la page d'accueil 
     * 
     * @Route("/", name="homepage")
     */
    public function index(PostRepository $postRepo)
    {

        return $this->render('home/index.html.twig', [
            'posts' => $postRepo->findLastPost(4)
            
        ]);
    }
    /**
     * Permet d'afficher la page à propos 
     * @Route("/show",name="homepage_show")
     */

     public function show ()
     {
        return $this->render('home/show.html.twig');
     }
}
