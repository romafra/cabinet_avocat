<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Entity\User;
use App\Entity\Avocats;
use App\Entity\Rdv;
use App\Form\ActuType;
use App\Form\EditRdvAvocatType;
use App\Form\EditUserType;
use App\Form\EditAvocatType;
use App\Repository\ActuRepository;
use App\Repository\AvocatsRepository;
use App\Repository\RdvRepository;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
    * Auteur : Damien
    * Le controleur ADMIN concerne l'ensemble des fonctionnalités relatives à l'administration du site 
    * (sauf la partie "Dossier", géré dans un controller différent) 
    * @Route("/admin", name="admin_")
    */
class AdminController extends AbstractController
{
    /**
    * Tableau de bord administrateur 
    * @Route("/", name="index")
    */
    public function index(AvocatsRepository $avocat)
    {
        $id = $this->getUser()->getId();
        return $this->render('admin/index.html.twig', [
            'avocat' => $avocat->findBy(
                array(
                    'user_id' => $id
                    )
                )
        ]);
    }

    /**
    * Liste des uilisateurs 
    * @Route("/utilisateurs", name="userslist")
    */
    public function usersList(UserRepository $users) {

        

    return $this->render('admin/userslist.html.twig', [
        'users' => $users->findAll()
    ]);
    }


    /**
     * Liste des rendez-vous de l'avocat connecté
     * @Route("/myrdv", name="listforid")
     */
    public function listrdvforid(RdvRepository $rdv, AvocatsRepository $avocat) {

            	
        $user = $this->getUser()->getId();
        $tabAvocat =  $avocat->findBy(["user_id"=> $user]);
        $id_Avocat = $tabAvocat[0]->getId();


        return $this->render('admin/listrdvforavocatid.html.twig', [
            'rdv' => $rdv->findBy(
                array(
                    'avocat' => $id_Avocat
                    )
                )
        ]);

    }


    /**
     * Ajout d'un nouvel article qui s'affichera sur la page d'accueil et dans la rubrique actualité du site
     * @Route("/newarticle", name="newarticle")
     */
    public function newRendezvous(Request $request)
    {
        $actu = new Actu();
        $form =$this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actu);
            $entityManager->flush();
            
            return $this->redirectToRoute('admin_listarticles');
        }
        return $this->render('admin/newactu.html.twig', [
            'controller_name' => 'RdvController',
            'form' => $form->createView()
        ]);
    }


     /**
     * Edition d'un article.
     * @Route("/editarticle/{id}", name="editarticle")
     */
    public function editarticle(Request $request, Actu $actu) {
        $form =$this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actu);
            $entityManager->flush();
            return $this->redirectToRoute('admin_listarticles');
        }

        return $this->render('admin/newactu.html.twig', [
            'form' => $form->createView()
        ]);

    }       


     /**
     * Listing des articles pour modification côté admin
     * @Route("/listarticles", name="listarticles")
     */
    public function actualites(ActuRepository $actu)
    {

        return $this->render('admin/listarticles.html.twig', [
            'actu' => $actu->findBy(array(), array('id' => 'DESC'))
        ]);

    } 


     /**
     * Edition du rendez-vous de l'avocat connecté 
     * @Route("/editrdv/{id}", name="editrdv")
     */
    public function cancelrdv(Request $request, Rdv $rdv) {
        $form =$this->createForm(EditRdvAvocatType::class, $rdv);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rdv);
            $entityManager->flush();
            return $this->redirectToRoute('admin_listforid');
        }

        return $this->render('rdv/editrdv.html.twig', [
            'rdvForm' => $form->createView()
        ]);

    }    

    /**
    * Enregistrement de l'avocat dans la table avocat afin que celui-ci soit visible sur le site internet (gestion des rdv, gestion des dossiers...) 
    * @Route("/newavocat/{user_id}", name="newavocat")
    */
    public function createAvocat(Request $request, EntityManagerInterface $manager, AvocatsRepository $avocat){

      
        $recupuserid = $request->get('user_id');
        $tabAvocat =  $avocat->findBy(["user_id"=> $recupuserid]);

        $init = "Y";

        if (count($tabAvocat) != null) {

            $this->addFlash('message', 'Cet avocat a déjà été initié. Il peut accéder à son tableau de bord administrateur si celui-ci détient bien le role AVOCAT.');
            return $this->redirectToRoute('admin_userslist');
        }

        else {

            $avocat = new Avocats();
            $avocat->setUserId($recupuserid);
            $avocat->setInit($init);
            $form = $this->createFormBuilder($avocat)
                ->add('firstname', HiddenType::class)
                ->add('lastname', HiddenType::class)
                ->add('user_id', HiddenType::class)
                ->add('init', HiddenType::class)
                ->getform();
            $form->handleRequest($request);
    
            $manager->persist($avocat);
            $manager->flush();
            $this->addFlash('message', 'Avocat a été initié avec succès. Ce dernier doit maintenant se connecter à son compte et compléter son profil');
    
            return $this->redirectToRoute('admin_userslist');

        }

    }


    /**
     * Edition du profil avocat lors de la toute première connexion au tableau de bord administrateur
     * afin de rendre obligatoire son nom et prénom pour que ceux-ci s'affichent bien lors de la prise d'un rendez-vous
     * @Route("/myprofil/{id}", name="editprofil")
     */
    public function editavocat(Request $request, Avocats $avocat){
        $form =$this->createForm(EditAvocatType::class, $avocat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avocat);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

    return $this->render('admin/myprofile.html.twig', [
        'form' => $form->createView()
    ]);

    }


    /**
     * Edition des rôles des utilisateurs pour permettre l'affichage du bouton "administration" aux avocats
     * @Route("/utilisateur/modifier/{id}", name="edituser")
     */
    public function editUser(User $user, Request $request){
        $form =$this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_userslist');
        }

    return $this->render('admin/edituser.html.twig', [
        'userForm' => $form->createView()
    ]);

    }

}
