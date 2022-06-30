<?php

namespace App\Controller;

use App\Entity\Todos;
use App\Form\TodoType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('todo')]

class TodoControllerBDDController extends AbstractController
{

    #[Route('/', name: 'todo.list')]
    public function displayTodo(ManagerRegistry $doctrine, Request $request): Response
    {
        $todo = new Todos(); //initialisation d'un constructeur 
        $form = $this->createForm(TodoType::class, $todo);
        $repository = $doctrine->getRepository(Todos::class);
        $todos = $repository->findAll();

        return $this->render('todo_controller_bdd/index.html.twig', [
            'todos' => $todos,
            'formPassed'=> $form->createView()
        ]);
    }

    #[Route('/{id<\d+>}', name: 'todo.detail')]
    public function detail(Todos $todo = null): Response
    {
        // Pas nécessaire avec le param Convertor 
        // $repository = $doctrine->getRepository(Todos::class);
        // $todo = $repository->find($id);

        if(!$todo){
            $this->addFlash('error', "la todo n'existe pas");
            return $this->redirectToRoute("todo.list");
        }

        return $this->render('todo_controller_bdd/detail.html.twig', [
            'todo' => $todo,
        ]);
    }

    #[Route('/add/{name}', name: 'todo.add')]
    public function addTodo(ManagerRegistry $doctrine, Request $request, $name): Response
    {
        $entiteManager = $doctrine->getManager();

        $todo = new Todos(); //initialisation d'un constructeur 

        // on ajoute avec les méthodes qui sont créés lors de la création d'une entité
        $todo->setTodoName($name);
        $todo->setIsCheckedTodo(false);  

        // ajoute l'opération d'insertion de la todo dans la transaction
        $entiteManager->persist($todo);

        $form->handleRequest($request);

        $entiteManager->flush();
        return $this->redirectToRoute('todo.list', [
            'todo'=> $todo,
            
        ]); 
    }

    #[Route('/delete/{id}', name: 'todo.delete')]
    public function deleteTodo(Todos $todo = null, ManagerRegistry $doctrine): RedirectResponse
    {
    // On récupère la todo
        // si elle existe
    if($todo){
        // suppression de la todo
        $manager = $doctrine->getManager();
        $manager->remove($todo);
        $manager->flush(); // exécute la transaction 
        $this->addFlash('success', 'La todo a bien été supprimé');
    }
    //sinon
    else{
        //message d'erreur
        $this->addFlash('error', 'La todo ne peut pas être supprimé, vérifié son existence');
    }
        return $this->redirectToRoute('todo.list');  
    }
}
