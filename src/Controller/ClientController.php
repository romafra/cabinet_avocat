<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;


class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index()
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    /**
     * @Route("/ajoutclient/{id_user}{titre}", name="ajoutclient"  ,  requirements={"id_user"="\d+"})
     */
    public function ajoutClient(Request $request,$id_user=null,$titre='')
    {

        // $user = $this->getUser()->getId();


        $client = new Client(); 
        $client->setStatut(1);
        $client->setUserId($id_user); 
        // var_dump($client);

        $form = $this->createFormBuilder($client)
        ->add('lastname', TextType::class,['label' => 'Nom :'])
        ->add('firstname', TextType::class,['label' => 'Prénom :'])
        ->add('adress', TextType::class,['label' => 'Adresse :'])
        ->add('zipcode', TextType::class,['label' => 'Code Postal :'])
        ->add('city', TextType::class,['label' => 'Ville :'])
        ->add('phone', TextType::class,['label' => 'Telephone :'])
        ->add('email', TextType::class,['label' => 'email :'])
        ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientinfo = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clientinfo);
            $entityManager->flush();
            
            // return $this->redirectToRoute('dossierliste');
            return $this->redirectToRoute('account_index');

        }
        return $this->render('client/formclient.html.twig', [
            'controller_name' => 'clientController',
            'form' => $form->createView(),'titre' => $titre
        ]);        
    }


/**
     * @Route("/listeclient", name="listeclient")
     */
    public function listedesclient(PaginatorInterface $paginator,Request $request)
    {


        // $user = $this->getUser()->getId();
        // $user=3;
       
        $repo1 = $this->getdoctrine()->getRepository(Client::class);
        $tabClient =  $repo1->findBy(array(),array('lastname' => 'ASC'));
        
        $DocumentPagnation = $paginator->paginate($tabClient,$request->query->getInt('page',1),3);
       
 
        return $this->render('client/listeclient.html.twig', [
            'controller_name' => 'ClientController',
            'titre' => 'Liste des Clients',
            'tabClient' => $DocumentPagnation
        ]);


      
    }





}
