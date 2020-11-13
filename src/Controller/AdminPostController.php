<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    /**
     * Permet modifier les posts 
     * 
     * @Route("admin/post/{id}/edit", name="admin_post_edit")
     *
     * @param Post $post
     * @return Response
     */
     public function edit(Post $post)
    {
        
        $form = $this->createForm(PostType::class,$post);

        return $this->render('admin/postAdmin/edit.html.twig',[
            'post'=> $post,
            'form' =>$form -> createView()
        ]);
    }
}
