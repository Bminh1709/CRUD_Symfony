<?php

// src/Controller/HomeController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/vn", name="homefor")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
}
