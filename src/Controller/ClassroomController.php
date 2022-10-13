<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/addclassroom', name: 'add_classroom')]
    public function addClassroom(ManagerRegistry  $doctrine)
    {
        $classrrom= new Classroom();
        $classrrom->setname("sarah");
        $student->setnbStudent(0);
        //$em= $this->getDoctrine()->getManager();
        $em= $doctrine->getManager();
        $em->persist($classrrom);
        $em->flush();
        //return $this->redirectToRoute("")
        return new Response("add classroom");
    }

    #[Route('/addClassroomForm', name: 'addClassroomForm')]
    public function addCForm(Request  $request,ManagerRegistry $doctrine)
    {
        $classrrom= new  Classroom();
        $form= $this->createForm(ClassroomType::class,$classrrom);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
             $em= $doctrine->getManager();
             $em->persist($classrrom);
             $em->flush();
             return  $this->redirectToRoute("addClassroomForm");
         }
        return $this->renderForm("classroom/add.html.twig",array("FormClassroom"=>$form));
    }


    #[Route('/updateClassroom/{id}', name: 'update_classroom')]
    public function updateClassroomForm($id,ClassroomRepository  $repository,Request  $request,ManagerRegistry $doctrine)
    {
        $classroom= $repository->find($id);
        $form= $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("addClassroomForm");
        }
        return $this->renderForm("classroom/update.html.twig",array("FormClassroom"=>$form));
    }
     
    #[Route('/removeclassroom/{id}', name: 'remove_classroom')]
    public function remove(ManagerRegistry $doctrine,$id,ClassroomRepository $repository)
    {
        $classrrom= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($classrrom);
        $em->flush();
        return $this->redirectToRoute("addClassroomForm");
    }

    #[Route('/listClassroom', name: 'listClassroom')]
    public function listClassroom(ClassroomRepository  $repository)
    {
        $classroom= $repository->findAll();
        return $this->render("classroom/list.html.twig",array("tabClassroom"=>$classroom));
    }
}
