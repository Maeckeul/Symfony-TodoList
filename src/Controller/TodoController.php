<?php

namespace App\Controller;

use App\Model\TodoModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController {

    /**
     * Liste des tâches
     * 
     *@Route("/todos", name="todo_list")
     */
    public function todoList() {

        $todos = TodoModel::findAll();

        return $this->render('todo/list.html.twig', [
           'todos' => $todos, 
        ]);
    }

    /**
     * Affichage d'une tâche
     * 
     * @Route("/todo/{id}", name="todo_show", requirements={"id" = "\d+"})
     */
    public function todoShow(int $id) {
        
        $todo = TodoModel::find($id);

        return $this->render('todo/single.html.twig', [
            'todo' => $todo
        ]);
    }
}