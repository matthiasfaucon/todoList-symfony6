<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')] // préfixe par défaut, chaque route maintenant aura comme préfixe "/todo" et il sera concaténé avec la route des autres méthodes

class TodoController extends AbstractController
{
    #[Route('', name: 'app_todo')]
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
        $this->addFlash('info', 'la liste des todos vient d\'être initialisée' );
    }
    // sinon j'affecte les données contenus dans la session à mon tableau de todos et je l'affiche avec twig
    else{
        $todos = $session->get('todos');
    }
        return $this->render('todo/index.html.twig');
    }

    #[Route('/add/{name?nom de la todo}/{content?vide}', 
    name: 'todo.add',
    // defaults: ['content' => 'vide', 'name' => 'nom de la todo'] //on ne peut pas mettre name par defaut uniquement car une url se lis de droite à gauche.De plus, symfony ne sait pas où mettre la valeur par défaut (donc erreur). 
    )]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();

        // Vérifier si il y a le tableau de todos dans la session
        // si oui
        if($session->has('todos')) {
            $todos = $session->get('todos');
            // Vérifier s'il y a une todo avec le même nom
                if (isset($todos[$name])){
                    //si oui
                        // afficher erreur
                        $this->addFlash('errorExist', "la todo: $name est déjà dans le tableau todos" );
                } else{
                    //si non
                        // ajouter la todo dans le tableau et message de succès 
                        $todos[$name] = $content;
                        //message Flash
                        $this->addFlash('success', 'Ajout de la todo réussi' );
                        $session->set('todos', $todos);
                }
        }
        //sinon
        else{
            // affiche erreur et renvoie vers le controlleur index
            $this->addFlash('error', 'Aucune liste de todos dans la session existante' );
            // return $this->redirectToRoute('app_first');
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();

        // Vérifier si il y a le tableau de todos dans la session
        // si oui
        if($session->has('todos')) {
            $todos = $session->get('todos');
            // Vérifier s'il y a une todo avec le même nom
                if (!isset($todos[$name])){
                    //si oui
                        // afficher erreur
                        $this->addFlash('errorExist', "la todo: $name n'existe pas dans le tableau todos" );
                } else{
                    //si non
                        // ajouter la todo dans le tableau et message de succès 
                        $todos[$name] = $content;
                        //message Flash
                        $this->addFlash('success', 'la todo a été modifiée avec succès' );
                        $session->set('todos', $todos);
                }
        }
        //sinon
        else{
            // affiche erreur et renvoie vers le controlleur index
            $this->addFlash('error', 'Aucune liste de todos dans la session existante' );
            // return $this->redirectToRoute('app_first');
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();

        // Vérifier si il y a le tableau de todos dans la session
        // si oui
        if($session->has('todos')) {
            $todos = $session->get('todos');
            // Vérifier s'il y a une todo avec le même nom
                if (!isset($todos[$name])){
                    //si oui
                        // afficher erreur
                        $this->addFlash('errorExist', "la todo: $name n'existe pas dans le tableau todos" );
                } else{
                    //si non
                        // supprime la todo dans le tableau et message de succès 
                        unset($todos[$name]);
                        //message Flash
                        $this->addFlash('success', 'la todo a été modifiée avec succès' );
                        $session->set('todos', $todos);
                }
        }
        //sinon
        else{
            // affiche erreur et renvoie vers le controlleur index
            $this->addFlash('error', 'Aucune liste de todos dans la session existante' );
            // return $this->redirectToRoute('app_first');
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
{
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('app_todo');
    }
}