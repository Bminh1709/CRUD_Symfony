<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/data", name="api_data")
     */
    public function apiData()
    {
        $data = [
            'message' => 'This is the API response',
            'timestamp' => time(),
        ];

        return new JsonResponse($data);
    }
}
