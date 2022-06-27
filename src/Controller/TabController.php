<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route("/tab/{nbrNotes<\d+>?5}", name: 'app_tab')]
    public function index($nbrNotes): Response
    {
        $notes = [];
        for ($i=0; $i < $nbrNotes; $i++) { 
            $notes[$i] = rand(0,20);
        }
         
        return $this->render('tab/index.html.twig', [
        'notes' => $notes,
        ]);
    }
}
