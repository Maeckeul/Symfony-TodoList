<?php

namespace App\Controller;

use App\Model\TodoModel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/todo")
 */
class TodoApiController extends AbstractController
{

    /**
     * @Route("/status", name="api_todo_status", methods={"POST"})
     */
    public function todoStatus(Request $request, TodoModel $todoModel)
    {
        $todoId = $request->request->get('id');
        $todoStatus = $request->request->get('status');
        $result = $todoModel->setStatus($todoId, $todoStatus);

        // je renvoi une reponse qui permet au client AJAX de comprendre que la MAJ à bien été effectuée
        // On envoi le code HTTP 200 lorsque c'est bon sinon 404 
        return new JsonResponse(
            ["id" => $todoId, "success" => $result], 
            $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @Route("/delete", name="api_todo_delete", methods={"POST"})
     */
    public function todoDelete(Request $request, TodoModel $todoModel)
    {
        $todoId = $request->request->get('id');
        $result = $todoModel->delete($todoId);

        return new JsonResponse(
            ["id" => $todoId, "success" => $result], 
            $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }
}