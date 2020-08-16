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
    public function todoShow($id) {

        $todo = TodoModel::find($id);

        if(!$todo) {
            throw $this->createNotFoundException("Cette tâche n'existe pas !");
        }

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

        $result = $todoModel->setStatus($id, $status);

        if(!$result) {
            throw $this->createNotFoundException("Cette tâche n'existe pas !");
        }

        $this->addFlash(
            'info',
            'Statut mis à jour !'
        );

        return $this->redirectToRoute('todo_list');
    }

    /**
     * Ajout d'une tâche
     * 
     * @Route("todo/add", name="todo_add", requirements={"id" = "\d+"}, methods={"POST"})
    */
    public function todoAdd(Request $request) {
        
        $task = $request->request->get('task');

        if(empty($task)) {

            $this->addFlash(
                'danger',
                'On ne peut pas ajouter de tâches vides !'
            );

        } else {

        $todoModel = new TodoModel();
        $todoModel->add($task);

        $this->addFlash(
                'success',
                'Une tâche a été ajoutée !'
            );
        }

        return $this->redirectToRoute('todo_list');
    }

    /**
     * Suppression d'une tâche d'une tâche
     * 
     * @Route("todo/{id}/delete", name="todo_delete", methods={"POST"})
     */
    public function todoDelete($id, TodoModel $todoModel) {

        $result = $todoModel->delete($id);

        if(!$result) {
            throw $this->createNotFoundException("Cette tâche n'existe pas !");
        }

        $this->addFlash(
            'warning',
            'La tâche a été supprimée !'
        );

        return $this->redirectToRoute('todo_list');
    }

    /**
     * Réinitialisation des tâches
     * 
     * @Route("/todos/reset", name="todo_reset", methods={"GET"})
     */
    public function resetTodos(TodoModel $todoModel) {

        $todoModel->reset();

        $this->addFlash(
            'info',
            'Les tâches ont été réinitialisées !'
        );

        return $this->redirectToRoute('todo_list');
    }
}