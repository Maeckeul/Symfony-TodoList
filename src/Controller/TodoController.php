<?php

namespace App\Controller;

use App\Model\TodoModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController {

    /**
     * Liste des tâches
     * 
     *@Route("/todos", name="todo_list", methods={"GET"})
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
     * @Route("/todo/{id}", name="todo_show", requirements={"id" = "\d+"}, methods={"GET"})
     */
    public function todoShow(int $id) {

        $todo = TodoModel::find($id);

        return $this->render('todo/single.html.twig', [
            'todo' => $todo
        ]);
    }

    /**
     * Changement de statut
     * 
     * @Route("/todo/{id}/{status}", name="todo_set_status", requirements={"id" = "\d+", "status" = "done|undone"}, methods={"GET"})
     */
    public function todoSetStatus($id, $status, TodoModel $todoModel) {

        $todoModel->setStatus($id, $status);

        $this->addFlash(
            'info',
            'Statut mis à jour !'
        );

        return $this->redirectToRoute('todo_list');
    }

    /**
     * Ajout d'une tâche
     * 
     * @Route("todo/add", name="todo_add", methods={"POST"}, methods={"POST"})
     * 
     * La route est définie en POST parce qu'on veut ajouter une ressource sur le serveur
     */
    public function todoAdd(Request $request) {
        
        $task = $request->request->get('task');
        $todoModel = new TodoModel();
        $todoModel->add($task);

        $this->addFlash(
            'success',
            'Une tâche a été ajoutée !'
        );

        return $this->redirectToRoute('todo_list');
    }
}