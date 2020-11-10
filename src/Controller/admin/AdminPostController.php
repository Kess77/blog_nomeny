<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AbstractController
{
    /**
     * @Route("/admin/post", name="admin_post")
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            
        ]);
    }
}
