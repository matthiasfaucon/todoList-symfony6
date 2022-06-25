<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        $session = $request->getSession(); // équivaut à récupérer session_start()
        // $nbrVisite = 0;
        if ($session->has('nbrVisiteTest')){
            $nbrVisite = $session->get('nbrVisiteTest') + 1;
        } else {
            $nbrVisite = 1;
        }
        $session->set('nbrVisiteTest', $nbrVisite);
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
}
