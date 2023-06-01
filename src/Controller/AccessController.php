<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Admin;
use App\Form\AdminType;
use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CoursesRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AccessController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('access/index.html.twig', [
            'controller_name' => 'AccessController',
        ]);
    }

    /**
     * @Route("/signup", name="admin_signup", methods={"GET","POST"})
     */
    public function SignUp(Request $request)
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
         
        if ($this->saveChanges($form, $request, $admin)) {   
            return $this->redirectToRoute('admin_login');
        }
        else {
            return $this->render('access/signup.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    public function saveChanges($form, $request, $admin)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $admin->setFirstname($request->request->get('admin')['firstname']);
            $admin->setLastname($request->request->get('admin')['lastname']);
            $admin->setPhone($request->request->get('admin')['phone']);
            $admin->setGender($request->request->get('admin')['gender']);
            $admin->setGmail($request->request->get('admin')['gmail']);
            $admin->setPass($request->request->get('admin')['pass']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
            
            return true;
        }
        return false;
    }

    
}
