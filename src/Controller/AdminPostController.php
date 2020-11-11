<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AbstractController
{
    /**
     * @Route("/admin/post", name="admin_post_index")
     */
    public function index(PostRepository $repo)
    {
        return $this->render('admin/postAdmin/index.html.twig', [
            "posts" => $repo -> findAll()
        ]);
    }
}
