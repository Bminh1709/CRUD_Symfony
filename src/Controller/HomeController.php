<?php

// src/Controller/HomeController.php
namespace App\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Course;

class HomeController extends AbstractController
{
    // /**
    //  * @Route("/homepage", name="homefor")
    //  */
    // public function index()
    // {
    //     return $this->render('index.html.twig');
    // }

      /**
     * @Route("/homepage", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('homepage.html.twig');
    }



    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    // /**
    //  * @Route("/list", name="courses_list")
    //  */
    // public function list(): JsonResponse
    // {
    //     $courses = $this->courseRepository->findAll();
    //     $responseData = [];

    //     foreach ($courses as $course) {
    //         $responseData[] = [
    //             'id' => $course->getId(),
    //             'name' => $course->getName(),
    //             'startday' => $course->getStartday()->format('d/m/y'),
    //             'endday' => $course->getEndday()->format('d/m/y'),
    //             'description' => $course->getDes(),
    //             'price' => $course->getPrice()
    //         ];
    //     }

    //     return $this->json($responseData);
    // }


    /**
     * @Route("/courses/list", name="courses_list")
     */
    public function list(): JsonResponse
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();

        $responseData = [];
        foreach ($courses as $course) {
            $responseData[] = [
                'id' => $course->getId(),
                'name' => $course->getName(),
                'price' => $course->getPrice()

                // Add more properties as needed
            ];
        }

        return $this->json($responseData);
    }

     /**
     * @Route("/courseApi", name="homefor")
     */
    public function courseApi()
    {
        return $this->render('courseApi.html.twig');
    }
}
