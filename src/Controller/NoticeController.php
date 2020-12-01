<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NoticeController extends AbstractController
{
    /**
     * @Route("/mentions_legales", name="notice_mentions_legales")
     */
    public function mentions()
    {
        return $this->render('notice/mentions.html.twig');
            
    }
    /**
     * @Route("/politique_de_confidentialite",name="notice_politique_de_confidentialite")
     *
     * 
     */
    public function politiqueConf(){

        return $this->render('notice/politiqueConf.html.twig');
    }
    /**
     * @Route("/cgu",name="notice_cgu")
     *
     * 
     */
    public function cgu(){

        return $this->render('notice/cgu.html.twig');
    }

}
