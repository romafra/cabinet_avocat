<?php
// test 
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController{

/**
* @Route("connexion")
*/

    function Connexion(LoggerInterface $log){

        $response = new Response(
            'LoginController '. $log->info('I just got the logger'),
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        return $response;
    }


    
}