<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
   
    /**
    * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
    */
    public function index(Request $request)
    {
         // Nous récupérons le nom d'hôte depuis l'URL
        $hostname = $request->getSchemeAndHttpHost();

        // On initialise un tableau pour lister les URLs
        $urls = [];

        // On ajoute les URLs "statiques"
        $urls[] = ['loc' => $this->generateUrl('homepage')];
        $urls[] = ['loc' => $this->generateUrl('account_register')];
        $urls[] = ['loc' => $this->generateUrl('account_login')];
        $urls[] = ['loc' => $this->generateUrl('notice_mentions_legales')];
        $urls[] = ['loc' => $this->generateUrl('notice_politique_de_confidentialite')];
        $urls[] = ['loc' => $this->generateUrl('notice_cgu')];
        $urls[] = ['loc' => $this->generateUrl('homepage_show')];

        // On ajoute les URLs dynamiques des articles dans le tableau
        foreach ($this->getDoctrine()->getRepository(Post::class)->findAll() as $post) {
           
            $urls[] = [
                'loc' => $this->generateUrl('post_show', [
                    'slug' => $post->getSlug(),
                ]),
                'lastmod' => $post->getCreatedAt()->format('Y-m-d'),
                
            ];
        }
        // Fabrication de la réponse XML
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname
            ]),
            200
        );

        // Ajout des entêtes
        $response->headers->set('Content-Type', 'text/xml');

        // On envoie la réponse
        return $response;

    }
}
