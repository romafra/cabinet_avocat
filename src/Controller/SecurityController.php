<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
Use App\Form\RegistrationCustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//Auteur : Damien
//Le controller securité gère la partie d'inscription et de connexion au site internet

class SecurityController extends AbstractController
{
    /**
     * Formulaire d'inscription
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(RegistrationCustomerType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            $idnewUser = $user->getId();

            // redirection automatique vers la page d'inscription pour entrer l'utilisateur dans la table client
            // Mise en place par François
            return $this->redirectToRoute('ajoutclient',array('id_user' => $idnewUser));


        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/login", name="security_login")
     */
    public function login() {

        return $this->render('security/login.html.twig');

    }

     /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
        
    }

}
