<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
    $session = $request->getSession();
   // si je n'ai pas de tableau de todos je le crée et ensuite je l'affiche avec twig
    if (!$session->has('todos')){
        $todos = [
            'achat' => 'acheter une clé USB',
            'course' => 'prendre des tomates',
            'correction' => 'corriger mes devoirs'
        ];
        $session->set('todos', $todos);
    }
    // sinon j'affecte les données contenus dans la session à mon tableau de todos et je l'affiche avec twig
    else{
        $todos = $session->get('todos');
    }
        
     
        return $this->render('todo/index.html.twig');
    }


}
