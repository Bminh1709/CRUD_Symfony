<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Course;
use App\Entity\Admin;
use App\Entity\Teacher;
use App\Form\CourseType;
use App\Repository\CoursesRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TeacherController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @Route("/teacher", name="app_teacher")
     */
    public function index(): Response
    {
        $adminData = $this->session->get('adminData');
        // get Id from adminData session
        $adminId = $adminData['id'];

        // Get admin and function to check auth
        $em = $this->getDoctrine()->getManager();
        $adminFound = $em->getRepository('App\Entity\Admin')->find($adminId);
        $functionFound = $em->getRepository('App\Entity\Functions')->find(4);

        // check whether admin can access function or not
        if ($adminFound->getFunctions()->contains($functionFound)) {
            
            //$em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository(Teacher::class);
            $data = $repo->findAllTeacher();
            
            //$adminData = $this->session->get('adminData');

            return $this->render('teacher/index.html.twig', [
                'teachers' => $data,
                'admin' => $adminData,
            ]);

        }
        else 
        {
            return $this->render('CantAccess.html.twig', [
                'admin' => $adminData,
                'accessCode' => 3
            ]);
        }
    }
}
