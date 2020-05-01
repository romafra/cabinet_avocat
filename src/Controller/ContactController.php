<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * @Route("/contacjjt", name="contact")
     */
    public function index(Request $request)
    {

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
        
           $contactFormData = $form->getData();

               dump($contactFormData);
            // die();

            // $message = \Swift_Message::newInstance()
            //     ->setSubject('Contact Form Submission')
            //     ->setFrom($form->getData()['email'])
            //     ->setTo('mi6on@fre.fr')
            //     ->setBody(
            //         $form->getData()['Message'],
            //         'text/plain'
            //     );

            // $this->get('mailer')->send($message);

        //     $email = (new Email())
        //     ->from('hello@example.com')
        //     ->to('achatssurwww@gmail.com')
        //     ->cc('cc@example.com')
        //     ->bcc('bcc@example.com')
        //     ->replyTo('fabien@example.com')
        //     ->priority(Email::PRIORITY_HIGH)
        //     ->subject('Time for Symfony Mailer!')
        //     ->text('Sending emails is fun again!')
        //     ->html('<p>See Twig integration for better HTML integration!</p>');

        // $mailer->send($email);



          

           return $this->redirectToRoute('website_home');

           // do something interesting here
       }



        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController','form' => $form,'form' => $form->createView()
        ]);
    }
}
