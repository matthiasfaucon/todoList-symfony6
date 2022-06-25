<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController //si pas de "extends" pas de "render"
{
    #[Route('/first', name: 'app_first')] // "#" est un attribut, uniquement depuis php8 avant on devait utiliser des annotations // "/first" = URI
    public function index(): Response  // la fonction retourne une réponse (Framework request/response)
    {
        return $this->render("first/index.html.twig",[
            'name' => 'titou',
            'firstname' => 'matthias'
    ]);
    }

    // #[Route('/sayHello', name: 'say.hello')] // "#" est un attribut, uniquement depuis php8 avant on devait utiliser des annotations // "/first" = URI
    // public function sayHello(): Response  // la fonction retourne une réponse (Framework request/response)
    // {
    //     $rand = rand(0,10);
    //     var_dump($rand);
    //     if ($rand === 3){
    //         return $this->redirectToRoute('app_first');
    //     }
    //     return $this->render("first/hello.html.twig",[
    //         'name' => 'titou',
    //         'firstname' => 'matthias'
    // ]);
    // }

    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')] // "#" est un attribut, uniquement depuis php8 avant on devait utiliser des annotations // "/first" = URI
    public function sayHello($name, $firstname): Response  // Request ici est un objet HttpFoundation
    {
    // dd($request); //dd = die and dump
        return $this->render("first/hello.html.twig",[
            'nom' => $name,
            'prenom' => $firstname    
    ]);
    }

}
