<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Services\Pagination;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPostController extends AbstractController
{
    /**
     * @Route("/admin/post/{page<\d+>?1}", name="admin_post_index")
     */
    public function index(PostRepository $repo,$page,Pagination $pagination)
    {
        $pagination->setEntityClass(Post::class)
                    ->setPage($page);


        return $this->render('admin/postAdmin/index.html.twig', [
            'posts' => $pagination->getData(),
            'pages' => $pagination->getPages(),
            'page' => $page
        ]);
    }

      
    /**
     * Permet ajouter un post 
     * 
     * @Route("/admin/post/new", name="admin_post_new")
     *
     * @return Response
     */
     public function new(Request $request, EntityManagerInterface $manager)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

          $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /*
            if ($post->getCoverImage()->getImageFile()) {
                $post->getCoverImage()->setImageName($this->generateRandomString());
            }
            if ($post->getImageFirst()->getImageFile()) {
                $post->getImageFirst()->setImageName($this->generateRandomString());
            }
            if ($post->getImageSecond()->getImageFile()) {
                $post->getImageSecond()->setImageName($this->generateRandomString());
            }
        
            if ($post->getImageLast()->getImageFile()) {
                $post->getImageLast()->setImageName($this->generateRandomString());
            }*/
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($post->getTitle());
            $post->setSlug($slug);

            $post->setAuthor($this->getUser());
            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "l'annonce <strong>{$post->getTitle()}</strong> a été bien ajouté"
            );

            return $this->redirectToRoute('admin_post_index');

        }
        
        return $this->render('admin/postAdmin/new.html.twig',[
            'form' =>$form -> createView()
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

            return $this->redirectToRoute('admin_post_index');
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
