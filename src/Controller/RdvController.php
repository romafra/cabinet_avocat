<?php

namespace App\Controller;

use App\Repository\RdvRepository;
use App\Entity\Rdv;
use App\Form\RdvType;
use App\Form\EditRdvType;
use App\Repository\AvocatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;


/**
* Auteur : Damien
* Le controller Rdv permet la gestion des rendez-vous côté utilisateur. 
* @Route("/rdv", name="rdv_")
*/
class RdvController extends AbstractController
{

    /**
     * Prise de rendez-vous
     * @Route("/new", name="new")
     */
    public function newRendezvous(Request $request, \Swift_Mailer $mailer)
    {
        $status = "En attente";
        $user = $this->getUser()->getId();
        $rdv = new Rdv();
        $rdv->setUserId($user);
        $rdv->setStatus($status);
        $form =$this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rdv);
            $entityManager->flush();

            /** Récupération des données du formulaire */
            $contact = $form->getData();
            /** Configuration du mail d'envoi */
            $message = (new \Swift_Message('Nouvelle demande de RDV François'))
            ->setFrom('ce.rosemond@gmail.com')
            ->setTo('ce.rosemond@gmail.com')
            ->setBody(
                $this->renderView(
                    'emails/newrdv.html.twig', compact('contact')
                ),
                'text/html'
            );
            /** Génération du mail */
            $mailer->send($message);

            return $this->redirectToRoute('rdv_listforid');
        }
        return $this->render('rdv/newrdv.html.twig', [
            'controller_name' => 'RdvController',
            'form' => $form->createView()
        ]);
    }

    /**
     * Liste des rendez-vous pour l'utilisateur connecté
     * @Route("/myrdv", name="listforid")
     */
    public function listrdvforid(RdvRepository $rdv, AvocatsRepository $avocat) {
        $id = $this->getUser()->getId();

        return $this->render('rdv/listrdvforuserid.html.twig', [
            'rdv' => $rdv->findBy(
                array(
                    'user_id' => $id
                    )
                ),
            'avocat' => $avocat->findAll()
        ]);
        
    }

     /**
     * Edition d'un rendez-vous pour l'utilisateur connecté 
     * @Route("/editrdv/{id}", name="edit")
     */
    public function cancelrdv(Request $request, Rdv $rdv) {
        $form =$this->createForm(EditRdvType::class, $rdv);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rdv);
            $entityManager->flush();
            return $this->redirectToRoute('rdv_listforid');
        }

        return $this->render('rdv/editrdv.html.twig', [
            'rdvForm' => $form->createView()
        ]);

    }


}
