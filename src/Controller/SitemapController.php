<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format" = "xml"})
     */
    public function index(Request $request)
    {
        // On récupère le nom d'hôte depuis l'URL

        $hostname = $request->getSchemeAndHttpHost();

        // On initialise un tableau pour dumper les URL
        $urls = [];

        // On ajoute les URL statiques

        $urls[] = ['loc' => $this->generateUrl('website_home')];
        $urls[] = ['loc' => $this->generateUrl('website_competences')];
        $urls[] = ['loc' => $this->generateUrl('website_formations')];
        $urls[] = ['loc' => $this->generateUrl('website_contact')];

        // Fabrication de la réponse
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname
            ]),
            200
        );

        //Ajout des entetes HTTP
        $response->headers->set('Content-type', 'text/xml');

        // On envoie la réponse
        return $response;

    }
}
