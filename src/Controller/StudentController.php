<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Repository\ClubRepository;
use App\Repository\StudentRepository;

class StudentController extends AbstractController
{
    #[Route('/student/{var}', name: 'app_student')]
    public function index($var)
    {
      return new Response("Pizza".$var);
    }

    #[Route('/list', name: 'app_student1')]
    public function list()
    {
        $v1="3A31";
        $v2="j13";
        $formations = array(
            array('ref' => 'form147', 'Titre' => 'Formation Symfony
4','Description'=>'pratique',
                'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
                'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
                'Description'=>'theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
                'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
                'Description'=>'theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
                'nb_participants'=>12));
        return $this->render("student/list.html.twig",
        array("v1"=>$v1,"v2"=>$v2,"listformation"=>$formations));
    }

    #[Route('/reservation', name: 'app_reservation')]
    public function reservation()
    {
        return new Response("réservation!");
    }

    #[Route('/detail', name: 'app_detail')]
    public function detail(/*ref $ref*/)
    {
    return $this->render("student/detail.html.twig"/*,array("ref"=>$ref)*/);
    }

    #[Route('/clubs', name: 'app_club')]
    public function listClub(ClubRepository $repository)
    {
       $clubs=$repository->findAll();
       return $this->render("student/club.html.twig",array("tabclubs"=>$clubs));


    }

    #[Route('/students', name: 'app_student2')]
    public function liststudent(StudentRepository $repository)
    {
       $student=$repository->findAll();
       return $this->render("student/student.html.twig",array("tabstudent"=>$student));


    } 
     /**
     * @param $id
     * @param StudentRepository $repository
     * @Route ("Delete/{id}",name="D")
     */
    function Delete($id,StudentRepository  $repository){
        $em=$this->getDoctrine()->getManager();
        $classroom=$repository->find($id);
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute('A');
    }

}
