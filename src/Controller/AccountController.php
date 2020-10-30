<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    /**
     * Permet de se connecter au formulaire de connexion 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login()
    {
        return $this->render('account/login.html.twig'
            
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
        
    }
}
