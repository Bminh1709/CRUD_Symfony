<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Course;
use App\Entity\Teacher;
use App\Entity\Admin;
use App\Form\CourseType;
use App\Repository\CoursesRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdminController extends AbstractController
{
    //private $isLogin = false;
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


     /**
     * @Route("/login", name="admin_login")
     */
    public function login(): Response
    {
        return $this->render('access/login.html.twig', [
            'controller_name' => 'AccessController',
        ]);
    }

    /**
     * @Route("/admin", name="check-login", methods={"POST"})
     */
    public function checkCredentials(Request $request): Response
    {
        $gmail = $request->request->get('gmail');
        $password = $request->request->get('pass');

        $admin = $this->getDoctrine()->getRepository(Admin::class)->findOneBy(['gmail' => $gmail]);
        $pass = $this->getDoctrine()->getRepository(Admin::class)->findOneBy(['pass' => $password]);

        if ($admin !== null && $pass !== null) {
            $adminData = [
                'id' => $admin->getId(),
                'firstName' => $admin->getFirstName(),
                'lastName' => $admin->getLastName(),
                'phone' => $admin->getPhone(),
                'gmail' => $admin->getGmail(),
                'gender' => $admin->getGender()
            ];
            // Store the admin data in the session
            $this->session->set('adminData', $adminData);
            $this->session->set('isLogin', true);

            return $this->redirectToRoute('app_admin');
        } else {

             // Add message when login fail
             $this->addFlash('danger', 'Check username or password again!');

            return $this->render('access/login.html.twig', [
                'controller_name' => 'AccessController',
            ]);
        }
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logout(SessionInterface $session): Response
    {
        // Clear the login state from the session
        $session->remove('isLogin');

        // Redirect to the login page or any other desired page
        return $this->redirectToRoute('admin_login');
    }

    /**
     * @Route("/home", name="app_admin")
     */
    public function index(): Response
    {
        // Get the login state from the session
        $isLogin = $this->session->get('isLogin');

        $adminData = $this->session->get('adminData');
        // get Id from adminData session
        $adminId = $adminData['id'];

        // Get admin and function to check auth
        $em = $this->getDoctrine()->getManager();
        $adminFound = $em->getRepository('App\Entity\Admin')->find($adminId);
        $functionFound = $em->getRepository('App\Entity\Functions')->find(1);

        // Check login of admin
        if ($isLogin === true)
        {
            // check whether admin can access function or not
            if ($adminFound->getFunctions()->contains($functionFound)) {
                //$em = $this->getDoctrine()->getManager();

                $repo = $em->getRepository(Course::class);
        
                $data = $repo->findAllCourse();

                return $this->render('admin/index.html.twig', [
                    'courses' => $data,
                    'admin' => $adminData,
                ]);
            }
            else 
            {
                return $this->render('CantAccess.html.twig', [
                    'admin' => $adminData,
                    'accessCode' => 1
                ]);
            }
        }
        else
        {
            return $this->redirectToRoute('admin_login');
        }
        
    }
    /**
     * @Route("/admin/delete/{id}", name="admin_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('App\Entity\Course')->find($id);
        $em->remove($course);
        $em->flush();
        
        $this->addFlash(
            'error',
            'Course deleted'
        );
        
        return $this->redirectToRoute('app_admin');
    }


    /**
     * @Route("/admin/create", name="admin_create", methods={"GET","POST"})
     */
    public function createAction(Request $request)
    {
        $adminData = $this->session->get('adminData');
        // get Id from adminData session
        $adminId = $adminData['id'];

        // Get admin and function to check auth
        $em = $this->getDoctrine()->getManager();
        $adminFound = $em->getRepository('App\Entity\Admin')->find($adminId);
        $functionFound = $em->getRepository('App\Entity\Functions')->find(2);

        // check whether admin can access function or not
        if ($adminFound->getFunctions()->contains($functionFound)) {
            
            $course = new Course();
            $form = $this->createForm(CourseType::class, $course);
            //$adminData = $this->session->get('adminData');
            
            if ($this->saveChanges($form, $request, $course)) {
                
                return $this->redirectToRoute('app_admin');
            }
            return $this->render('admin/create.html.twig', [
                'form' => $form->createView(),
                'admin' => $adminData,
            ]);

        }
        else 
        {
            return $this->render('CantAccess.html.twig', [
                'admin' => $adminData,
                'accessCode' => 2
            ]);
        }
    }

    public function saveChanges($form, $request, $course)
    {
        $form->handleRequest($request);
        
        if ($form->isSubmitted()){
            $course->setName($request->request->get('course')['name']);
            //$course->setTeacher($request->request->get('course')['teacher']);
            $course->setDes($request->request->get('course')['des']);
            $course->setPrice($request->request->get('course')['price']);


            $teacherData = $request->request->get('teacher');

            if ($teacherData !== null && isset($teacherData['teacher'])) {
                $teacherId = $teacherData['teacher'];

                // Retrieve the Teacher entity from the database
                $teacher = $entityManager->getRepository(Teacher::class)->find($teacherId);

                // Set the teacher for the course
                $course->setTeacher($teacher);
            }

            $course->setStartday(\DateTime::createFromFormat('Y-m-d', $request->request->get('course')['startday']));
            $course->setEndday(\DateTime::createFromFormat('Y-m-d', $request->request->get('course')['endday']));
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();
            
            return true;
        }
        return false;
    }


    /**
     * @Route("/admin/edit/{id}", name="admin_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('App\Entity\Course')->find($id);
        $adminData = $this->session->get('adminData');
        
        $form = $this->createForm(CourseType::class, $course);
        
        if ($this->saveChanges($form, $request, $course)) {
            return $this->redirectToRoute('app_admin');
        }
        
        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
            'admin' => $adminData,
        ]);
    }





}
