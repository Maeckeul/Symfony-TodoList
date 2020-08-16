<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    /**
     * Page d'acceuil
     * 
     * @Route("/", name="homepage")
     */
    public function index() {
        return $this->render('default/index.html.twig');
    }
}