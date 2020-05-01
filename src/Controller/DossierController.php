<?php

namespace App\Controller;

use App\Entity\Avocats;
use App\Entity\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Dossier;
use App\Entity\Document;
use App\Entity\Rdv;
use App\Repository\DossierRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class DossierController extends AbstractController
{


    /**
     * @Route("dossier/dossierform/{id}/{client}", name="dossierform")
     */

    public function newDossier(Request $request,$id = null, $client="nouveau client")   // Création d'un dossier Client / $id = id du client , $client = nom du client
    {
        $user = $this->getUser()->getId();                  // Récupére user_id de l'avocat connecté

        $repo1 = $this->getdoctrine()->getRepository(Avocats::class);
        $tabAvocat =  $repo1->findBy(["user_id"=> $user]);            //  $tabAvocat  : tableau d' Entity de type Avocats , contient les attributs de l'avocat connecté
        $id_Avocat = $tabAvocat[0]->getId();                          //  Retourne l'id de l'avocat avec le getter getId() 

        if ($id == null)
                  $id=10;               
        $dossier = new Dossier();                   //  $dossier : instance de l' Entity Dossier
        $dossier->setDosavoid($id_Avocat);          //  initialisation des attributs de $dossier
        $dossier->setDosstatut(0);
        $dossier->setDoscliid($id);
        $dossier->setDosdate(new \DateTime('now'));
       
        $ref = 'Ref-' . $user .'-' . $id .'-' . rand(100, 9999);  // $ref : référence d'un dossier avec $user = id de l'avocat et $id = id du client + nb aléatoire
        $dossier->setDosref($ref);

        $form = $this->createFormBuilder($dossier)                  // création du formulaire 

        ->add('dosdate', DateType::class, ['label' => 'Date :',
            'format' => 'dd-MM-yyyy',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ]
        ])
        ->add('dosref', TextType::class,['label' => 'Ref :'])
        ->add('dosstatut', TextType::class,['label' => 'Statut :'])
        ->add('dosstatut', ChoiceType::class, [
            'choices' => [
            'En cours' => '0',
            'Suspendu' => '1',
            'Archivé' => '2'
            ],
            'expanded' => false,
            'multiple' => false,
            'label' => 'Statut du dossier'
        ])
        ->add('doscliid', HiddenType::class)
        ->add('dosavoid', HiddenType::class)
        ->add('dosdescription', TextType::class,['label' => 'Description :'])

        ->getForm();

        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {         //  Test si le formulaire a été soumis depuis le template et s'il est valide
            $dossierinfo = $form->getData();                    // Données saisies dans le formulaire sont récupérées dans un $dossierinfo
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dossierinfo);              // mise en attente 
            $entityManager->flush();                            // Enregistrement des données dans la BDD
            
            return $this->redirectToRoute('dossierliste');  // Redirection  vers la page liste des dossiers
        }
                                                            //  Appel du template qui affiche le formulaire 
        return $this->render('dossier/formdossier.html.twig', [
            'controller_name' => 'DossierController','client' => $client,
            'form' => $form->createView()
        ]);
    }

    

   /**
     * @Route("dossier/dossierliste", name="dossierliste")
     */
    public function listedossier( PaginatorInterface $paginator,Request $request)   //  Liste des dossiers pour un Avocat
    {
        $user = $this->getUser()->getId();      // Récupére id de l'avocat connecté
       
        $repo1 = $this->getdoctrine()->getRepository(Avocats::class); 
        $tabAvocat =  $repo1->findBy(["user_id"=> $user]);              //  $tabAvocat  : tableau d' Entity de type Avocats , contient les attributs de l'avocat connecté
        $id_Avocat = $tabAvocat[0]->getId();                            //  Retourne l'id de l'avocat avec le getter getId() 
  
        $repo = $this->getdoctrine()->getRepository(Dossier::class);    
        $tablodossier = $repo->findBy(["dosavoid"=> $id_Avocat],array('dosdate' => 'ASC'));  //  $tablodossier : tableau d' Entity de type Dossier qui contient tous les dossiers de l'avocat identifié
        $nbDossier = count($tablodossier);                              // retourne le nombre de dossier de l'avocat

        $DocumentPagnation = $paginator->paginate($tablodossier,$request->query->getInt('page',1),3);  // Gestion de la pagination des dossiers de l'avocat

        $repo3 = $this->getdoctrine()->getRepository(Client::class);  

        $tabClient = array();                        // tableau qui va contenir la liste des clienst par dossier
        $i=0;
        foreach($tablodossier AS $cle => $valeur) {             // Boucle pour alimenter la liste des clients par dossiers
            $unClient= $repo3->findBy(["id"=>  $tablodossier[$i]->getDoscliid()]);  // Retourne un Client depuis une Entity Client en lien avec un dossier
            $nomclient = $unClient[0]->getLastname();
            $j = $tablodossier[$i]->getDoscliid();      // $j = contient id du dossier concerné pour un client
            $tabClient[$j] = $nomclient;                 
            $i++;
        }
                                                    //   Appel du template listedossier.html.twig
        return $this->render('dossier/listedossier.html.twig', [
            'controller_name' => 'DossierControllerroller',
            'titre' => 'Liste des dossiers',
            'tablodossier' => $DocumentPagnation,'tabavocat' => $tabAvocat[0],'tabclient'=> $tabClient,'nbdossier' => $nbDossier
        ]);
    }


    /**
     * @Route("/unDossier/{id}/{cliid}", name="unDossier", requirements={"id"="\d+"},methods={"GET"})
     */

    public function unDossier($id,$cliid, PaginatorInterface $paginator,Request $request)      // affiche le conntenu d'un dossier / $id : id du dossier , $cliid : id du Client 
    {
        $repo = $this->getdoctrine()->getRepository(Dossier::class);    
        $unDossier = $repo->find($id);                                  //  Requéte pour recupérer le Dossier :  Entity Dossier

        $repo3 = $this->getdoctrine()->getRepository(Client::class);    
        $unClient = $repo3->findBy(["id"=> $cliid]);                    // requéte pour récupérer le Client : Entity Client

        $repo2 = $this->getdoctrine()->getRepository(Document::class); 
        $tablDocument = $repo2->findBy(["docdosid"=> $id]);             // requéte pour récupérer les  Document en lien avec le dossier : Entity Document
        $nbDeDoc = count($tablDocument);

        $DocumentPagnation = $paginator->paginate($tablDocument,$request->query->getInt('page',1),3);  // Gestion de la pagination

                                                                                     //  Appel du template qui affiche le Contenu d'un Dossier  
        return $this->render('dossier/undossier.html.twig', [
            'controller_name' => 'DossierController',
            'titre' => 'Un dossier','nbdedoc' => $nbDeDoc,
            'unDossier' => $unDossier,'tabDocument' => $DocumentPagnation,'unClient' => $unClient[0]
        ]);

    }


    
     /**
     * @Route("/dossierdocument/{id}/{ref}", name="dossierdocument") , requirements={"id"="\d+"},methods={"GET"})
     */

    public function newDocument(Request $request,$id,$ref, SluggerInterface $slugger) // Création d'un document  / $id : id du dossier , $ref : Référence du dossier
    {
        $document = new Document();             // $document instance Entity Document
        $document->setDoctype(0);               // Initialisation des attributs de $document
        $document->setDocstatut(0);
        $document->setDoctype(0);
        $document->setDocdosid($id);
        $document->setDocdate(new \DateTime('now'));

        $form = $this->createFormBuilder($document)  // Création du formulaire 
        ->add('docdate', DateType::class, ['label' => 'Date :',
            'format' => 'dd-MM-yyyy',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ]
        ])
        ->add('docsujet', TextType::class,['label' => '* Sujet :'])
        ->add('doctype', ChoiceType::class, [
            'choices' => [
                'Aucun' => '0',
                'Info' => '1',
                'Rapport' => '2',
                'Telecharger un document' => 3
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Type d \'evenement'
        ])
        ->add('docstatut', ChoiceType::class, [
                    'choices' => [
                    'A faire' => '0',
                    'En cours' => '1',                    
                    'Terminé' => '2'                    
                    ],
                    'expanded' => false,
                    'multiple' => false,
                    'label' => 'Statut de l\'evenement'
        ])
         
        ->add('brochure', FileType::class, [
            'label' => 'Fichier (PDF file)','attr' => array(
                'placeholder' => 'Selectionnez un fichier de type PDF taille max : 1024Ko'
                ),

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                     'mimeTypes' => [
                         'application/pdf',
                         'application/x-pdf',
                     ],
                    'mimeTypesMessage' => 'Le fichier doit être un document de type  PDF'
                ])
            ],
        ])

        ->add('docdosid', HiddenType::class)
        ->add('docdosid', HiddenType::class)
        ->getForm();

        $form->handleRequest($request);
                                                                    //  Test si le formulaire a été soumis depuis le template et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) { 

            $brochureFile = $form->get('brochure')->getData();     // On récupére le contenu du champ brochure  = champ upload
            $newFilename=null;

           if($brochureFile !=null){                                // Si c'est un upload de fichier
            $destination = $this->getParameter('kernel.project_dir').'\public\uploads';    // Dossier de destination du fichier upload. Pour un serveur linux, le changement des \public\uploads en /public/uploads est peut être nécessaire.
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $ref.'-'.$originalFilename.'.'.$brochureFile->guessExtension();  // Réécriture du nom de fichier avec la Ref de dossier
                                                       
            // Tranfert du fichier dans le site 
                $brochureFile->move(
                    $destination,
                    $newFilename
                );
            }

            $documentinfo = $form->getData();                       // Données saisies dans le formulaire sont récupérées dans un $documentinfo
            
            if ($newFilename != null){                              // Si le document est un fichier qui a été upload on modifie les attributs de l' Entity Document
                 $documentinfo->setDocsujet($newFilename);
                 $documentinfo->setDoctype(3);
                 $documentinfo->setDocstatut(1);
            }
           
            $entityManager = $this->getDoctrine()->getManager();    
            $entityManager->persist($documentinfo);                 // mise en attente 
            $entityManager->flush();                                // Enregistrement des données dans la BDD
            $idDoc = $documentinfo->getId();
                                       
            return $this->redirectToRoute('dossierliste');          // Redirection  vers la page liste des dossiers
        }
                                                                     //  Appel du template qui affiche le formulaire 
        return $this->render('dossier/formdocument.html.twig', [
            'controller_name' => 'DocumentController','Reference' => $ref ,'Titre' => 'Ajout d\'un Evenement au dossier : ',
            'form' => $form->createView()
        ]);
    }



     /**
     * @Route("/editdocument/{id}/{action}", name="editdocument") , requirements={"id"="\d+"},methods={"GET"})
     */

    public function editDocument(Request $request,$id,$action){  // Modification ou suppression d'un document / $id : id du document / $action = 1 modifier /$action = 0 supprimer

        if ($action == 1){                              // Gestion de l'affichage du template en fonction de $action 
            $titreTemplate = "Modification ";
            $subBouton = "Modifier";
        }
        else
        {
            $titreTemplate = "Suppression ";
            $subBouton = "Supprimer";
        }

        $repo = $this->getdoctrine()->getRepository(Document::class);   
        $document = $repo->find($id);                                   // Requéte pour récupérer le document

        $form = $this->createFormBuilder($document)                      // création et initialisation du formulaire 
        ->add('docdate', DateType::class, ['label' => 'Date :',
            'format' => 'dd-MM-yyyy',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ]
        ])
        ->add('docsujet', TextType::class,['label' => 'Sujet :'])
        ->add('doctype', ChoiceType::class, [
            'choices' => [
                'Aucun' => '0',
                'Info' => '1',
                'Rapport' => '2'
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Type d\'evenement'
        ])
        ->add('docstatut', ChoiceType::class, [
                    'choices' => [
                    'A faire' => '0',
                    'En cours' => '1',
                    'Terminé' => '2'
                    ],
                    'expanded' => false,
                    'multiple' => false,
                    'label' => 'Statut de l\'evenement'
        ])
        ->add('docdosid', HiddenType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {                 //  Test si le formulaire a été soumis depuis le template et s'il est valide
            $documentinfo = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            if ($action == 1)                                           // Test de l'action à executer
                $entityManager->persist($documentinfo);                 // Modification
            else
                $entityManager->remove($documentinfo);                  // Suppression
            $entityManager->flush();
           
            return $this->redirectToRoute('dossierliste');              // Redirection vers la page liste des dossiers
        }
                                                                        //  Appel du template qui affiche le formulaire 
             return $this->render('dossier/formdocument.html.twig', [
            'controller_name' => 'DocumentController','Reference' =>'d\'un Evenement','Titre' =>$titreTemplate,
            'form' => $form->createView()
        ]);

    }

    

/**
     * @Route("client/unDossierClient/{id}/{cliid}", name="unDossierClient", requirements={"id"="\d+"},methods={"GET"})
     */

    public function unDossierClient($id,$cliid, PaginatorInterface $paginator,Request $request){    // Affichage d'un dossier client / $id : id du document / $cliid = id du Client

        $repo = $this->getdoctrine()->getRepository(Dossier::class);
        $unDossier = $repo->find($id);                                           //  Requéte pour recupérer le Dossier :  Entity Dossier

        $repo3 = $this->getdoctrine()->getRepository(Client::class);
        $unClient = $repo3->findBy(["id"=> $cliid]);                             //  Requéte pour recupérer le Client :  Entity Client

        $repo2 = $this->getdoctrine()->getRepository(Document::class);           //  Requéte pour recupérer le Dossier :  Entity Document   
        $tablDocument = $repo2->findBy(["docdosid"=> $id]);

        $nbDeDoc = count($tablDocument);                                        // Nombre de Documents pour un dossier

        $DocumentPagnation = $paginator->paginate($tablDocument,$request->query->getInt('page',1),3);       // gestion de la pagination

                                                                                 //  Appel du template qui affiche le Dossier pour le suivi client 
        return $this->render('dossier/undossierclient.html.twig', [
            'controller_name' => 'DossierController',
            'titre' => 'Un dossier','nbdedoc' => $nbDeDoc,
            'unDossier' => $unDossier,'tabDocument' => $DocumentPagnation,'unClient' => $unClient[0]
        ]);

        return new Response('<h1>Vous consulté le dossier :' . $unDossier->getDosref() . '</h1>');

    }


     /**
     * @Route("client/dossierlisteclient", name="dossierlisteclient")
     */
    public function listedossierclient( PaginatorInterface $paginator,Request $request)
    {

        $user = $this->getUser()->getId();                  // Récupére id de l'utilisateur connecté
        $roles = $this->getUser()->getRoles();              // Récupére le role de l'utilisateur conecté
       
        $repo1 = $this->getdoctrine()->getRepository(Client::class);  
        $tabClient =  $repo1->findBy(["user_id"=> $user]);  // Récupére dans $tabClient le client  

        if ($roles[0] == 'ROLE_AVOCAT' ){   // Test si la personne connecté est un Avocat
            return $this->redirectToRoute('dossierliste');   // redirection vers la liste des dossiers d' un avocat
        }
        elseif (count($tabClient )> 0) {         // Test si la personne connecté a déja compte client  / $tabClient est > 0
            $id_Client = $tabClient[0]->getId();
            $repo = $this->getdoctrine()->getRepository(Dossier::class);
            $tablodossier = $repo->findBy(["doscliid"=> $id_Client],array('dosdate' => 'ASC'));
            $nbDossier = count($tablodossier);

            $DocumentPagnation = $paginator->paginate($tablodossier,$request->query->getInt('page',1),3);  // gestionde la pagination

            return $this->render('dossier/listedossierclient.html.twig', [   // Affichage du template de suivi de dossier client
                'controller_name' => 'DossierControllerroller',
                'titre' => 'Liste des dossiers',
                'tablodossier' => $DocumentPagnation,'tabclient' => $tabClient[0],'nbdossier'=> $nbDossier
            ]);
        }
        else{                           //  la Peronne connectée n'a pas de compte client on la redirige vers l'ecran d'inscription
            return $this->redirectToRoute('ajoutclient',array('id_user' => $user));
        }
    }


}
