<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminCommentController extends AbstractController
{
    /**
     * Permet de lister les commentaires 
     * @Route("/admin/comment", name="admin_comment_index")
     */
    public function index(CommentRepository $repo)
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments'=>$repo->findAll()
        ]);
    }
    /**
     * Permet de modifier les articles 
     * 
     * @Route("/admin/comment/{id}/edit", name ="admin_comment_edit")
     *
     * @return void
     */
    public function edit(Comment $comment,Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdminCommentType::class,$comment);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
            'success',
            "Votre commentaire {$comment->getId()} a été bien modifié"
            );

        return    $this->redirectToRoute('admin_comment_index');

        }

        return $this->render('admin/comment/edit.html.twig',[
            'comment'=>$comment,
            'form'=> $form->createView()

        ]);

    }
    /**
     * Permet de supprimer des commentaires 
     * 
     * @Route("/admin/comment/{id}/delete",name="admin_comment_delete")
     *
     * @param Comment $comment
     * @return void
     */
    public function delete(Comment $comment, EntityManagerInterface $manager){

        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
        'success',
        "Votre message  a été supprimé"
        );

        return    $this->redirectToRoute('admin_comment_index');
    }
}
