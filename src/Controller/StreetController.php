<?php

namespace App\Controller;
use App\Entity\Street;
use App\Form\StreetType;
use App\Repository\StreetRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreetController extends AbstractController
{
    #[Route('/street', name: 'app_street')]
    public function index(): Response
    {
        return $this->render('street/index.html.twig', [
            'controller_name' => 'StreetController',
        ]);
    }

    #[Route('/addstreet', name: 'add_street')]
    public function addStreet(ManagerRegistry  $doctrine)
    {
        $street= new Street();
        $street->setname("centre-ville");
        $street->setlenght(4.5);
        //$em= $this->getDoctrine()->getManager();
        $em= $doctrine->getManager();
        $em->persist($street);
        $em->flush();
        //return $this->redirectToRoute("")
        return new Response("add street");
    }

    #[Route('/addStreetForm', name: 'addStreetForm')]
    public function addStreetForm(Request  $request,ManagerRegistry $doctrine)
    {
        $street= new  Street();
        $form= $this->createForm(StreetType::class,$street);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($street);
            $em->flush();
            return  $this->redirectToRoute("addStreetForm");
        }
        return $this->renderForm("street/add.html.twig",array("FormStreet"=>$form));
    }


    #[Route('/updateStreet/{id}', name: 'update_street')]
    public function updateStreetForm($id,StreetRepository  $repository,Request  $request,ManagerRegistry $doctrine)
    {
        $street= $repository->find($id);
        $form= $this->createForm(StreetType::class,$street);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("addStreetForm");
        }
        return $this->renderForm("Street/update.html.twig",array("FormStreet"=>$form));
    }

    #[Route('/removestreet/{id}', name: 'remove_street')]
    public function remove(ManagerRegistry $doctrine,$id,StreetRepository $repository)
    {
        $street= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($street);
        $em->flush();
        return $this->redirectToRoute("addStreetForm");
    }

    #[Route('/listStreet', name: 'liststreet')]
    public function listStreet(StreetRepository  $repository)
    {
        $street= $repository->findAll();
        return $this->render("street/list.html.twig",array("tabStreet"=>$street));
    }


}
