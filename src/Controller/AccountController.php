<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function register(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder)
    {

        $user = new User();

        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            // encoder le mot de passe
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);


            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a été bien enregistré'
            );

            $this->redirectToRoute("account_login");
        }
        
        return $this->render('account/register.html.twig',[
            'form'=>$form->createView()
        ]);

    }
    /**
     * Permet  d'affichet et de  traiter le formulaire de modification de profil 
     * 
     * @Route("/account/profil",name="account_profil")
     *
     * @return Response
     */
    public function profil (Request $request, EntityManagerInterface $manager){

        $user = $this->getUser();

        $form = $this->createForm(ProfilType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre modification de profil a été bien enregistré'


            );
        }

        return $this->render('account/profil.html.twig',[
            'form'=>$form->createView(),
            
        ]);
    }
}
