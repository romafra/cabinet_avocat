<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ActuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Auteur : Damien
 * Le controller website contient l'affichage des différentes pages du frontend
 */
class WebsiteController extends AbstractController
{
    /**
     * Page d'accueil
     * @Route("/", name="website_home")
     */
    public function index(ActuRepository $actu)
    {
        return $this->render('website/index.html.twig', [
            'controller_name' => 'WebsiteController',
            'actu' => $actu->findBy(array(), array('id' => 'DESC'),2)
        ]);
    }


    /**
     * Page des compétences
     * @Route("/competences", name="website_competences")
     */
    public function competences()
    {
        return $this->render('website/competences.html.twig', [
            'controller_name' => 'WebsiteController',
        ]);
    } 


    /**
     * Page des formations
     * @Route("/formations", name="website_formations")
     */
    public function formations()
    {
        return $this->render('website/formation.html.twig', [
            'controller_name' => 'WebsiteController',
        ]);
    }


     /**
     * Page d'actualité
     * @Route("/actualite", name="website_actus")
     */
    public function actualites(ActuRepository $actu)
    {

        return $this->render('website/actu.html.twig', [
            'actu' => $actu->findBy(array(), array('id' => 'DESC'),4)
        ]);

    } 

    /**
     * Page du formulaire de contact
     * @Route("/contact", name="website_contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();


            // Paramétrage du mail 
            $message = (new \Swift_Message('Nouveau contact du site web'))
            ->setFrom($contact['email'])
            ->setTo('com.eklair.dev@gmail.com')
            ->setBody(
                $this->renderView(
                    'emails/contact.html.twig', compact('contact')
                ),
                'text/html'
            );

            // Envoi du mail     
            $mailer->send($message);

            // Affichage d'un message Flash de confirmation
            $this->addFlash('message', 'Votre message a bien été envoyé. Nous reviendrons vers vous dans les meilleurs délais !');
        }

        return $this->render('website/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }    


}
