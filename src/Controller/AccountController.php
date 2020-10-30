<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet de se connecter au formulaire de connexion 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error =$utils->getLastAuthenticationError();

        // recuperer le dernier nom
        $username = $utils->getLastUsername();


        return $this->render('account/login.html.twig',[
            'hasError'=> $error !== null,
            'username'=>$username
        ]    
        );
    }
    /**
     * Permet de se deconnecter au formulaire de connexion 
     * @Route("/logout", name="account_logout")
     * 
     * @return void
     */
    public function logout()
    {
        // return rien
    }
    /**
     * Permet aux utilisateur de s\'incrire , un formulaire d\'inscription
     * 
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register()
    {

        $user = new User();

        $form = $this->createForm(RegistrationType::class,$user);
        
        return $this->render('account/register.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}
