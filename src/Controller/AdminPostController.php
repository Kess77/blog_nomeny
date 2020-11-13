<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/admin/post/{id}/edit", name="admin_post_edit")
     *
     * @param Post $post
     * @return Response
     */
     public function edit(Post $post, Request $request, EntityManagerInterface $manager)
    {
        
        $form = $this->createForm(PostType::class,$post);

          $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "l'annonce <strong>{$post->getTitle()}</strong> a été bien modifié"
            );

        }
        return $this->render('admin/postAdmin/edit.html.twig',[
            'post'=> $post,
            'form' =>$form -> createView()
       ]);
    }
    /**
     * Permet de supprimer une article
     * 
     * @Route("/admin/post/{id}/delete",name="admin_post_delete")
     *
     * @param Post $post
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Post $post,EntityManagerInterface $manager){

        $manager->remove($post);
        $manager->flush();

        $this->addFlash(
                'success',
                "l'annonce <strong>{$post->getTitle()}</strong> a été bien supprimée"
            );

        return $this->redirectToRoute('admin_post_index');
    }
    
}
