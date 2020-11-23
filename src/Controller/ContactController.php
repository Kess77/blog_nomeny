<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * Permet de contacter l'auteur du blog 
     * @Route("/contact", name="contact_index")
     */
    public function index(Request $request,EntityManagerInterface $manager)
    {
        $contact = new Contact();

        $form    = $this->createForm(ContactType::class,$contact);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
            'success',
            'Merci à vous, nous allons faire le nécéssaire '
            );

            $this->redirectToRoute('homepage');

        }



        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
