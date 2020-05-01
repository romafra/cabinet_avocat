<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Auteur : Damien
 * Affiche du tableau de bord utilisateur
 * @Route("/account", name="account_")
 */
class AccountController extends AbstractController
{
     /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

}