<?php

namespace App\Controller;

use App\Entity\Todos;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('todo')]

class TodoControllerBDDController extends AbstractController
{

    #[Route('/', name: 'todo.list')]
    public function displayTodo(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Todos::class);
        $todos = $repository->findAll();
        return $this->render('todo_controller_bdd/index.html.twig', [
            'todos' => $todos,
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

    #[Route('/add', name: 'todo.add')]
    public function addTodo(ManagerRegistry $doctrine): Response
    {
        $entiteManager = $doctrine->getManager();
        $todo = new Todos(); //initialisation d'un constructeur 
        // on ajoute avec les méthodes qui sont créés lors de la création d'une entité
        $todo->setTodoName('devoir');
        $todo->setTodoContent('Apprendre symfony');
        $todo->setIsCheckedTodo(false);   

        // ajoute l'opération d'insertion de la personne dans la transaction
        $entiteManager->persist($todo);

        $entiteManager->flush();
        return $this->render('todo_controller_bdd/addTodo.html.twig', [
            'todo' => $todo,
        ]);
    }

    #[Route('/delete/{name}', name: 'todo.delete')]
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
